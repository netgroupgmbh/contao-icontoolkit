<?php

/**
 * @since       26.11.2025 - 16:20
 *
 * @author      Patrick Froch <info@netgroup.de>
 *
 * @see         http://www.netgroup.de
 *
 * @copyright   NetGroup GmbH 2025
 */

declare(strict_types=1);

namespace NetGroup\IconToolkit\Classes\Services\Helper;

use NetGroup\IconToolkit\Classes\Services\Factories\FinderFactory;

class IconHelper
{


    /**
     * @param string                $projectDir
     * @param string                $iconsJsonPath
     * @param FinderFactory         $finderFactory
     * @param FileAbstractionHelper $file
     */
    public function __construct(
        private readonly string $projectDir,
        private readonly string $iconsJsonPath,
        private readonly FinderFactory $finderFactory,
        private readonly FileAbstractionHelper $file
    ) {
    }


    /**
     * Gibt die Informationen der Icons zurück
     *
     * @return mixed[]
     *
     * @throws \JsonException
     */
    public function parseIconList(): array
    {
        $fs = $this->finderFactory->createFileSystem();

        if ($fs->exists($this->projectDir . $this->iconsJsonPath)) {
            $contnet = $this->file->getContents($this->projectDir . $this->iconsJsonPath);

            if (!empty($contnet)) {
                return \json_decode($contnet, true, 512, JSON_THROW_ON_ERROR) ?: [];
            }
        }

        return [];
    }


    /**
     * Gibt die Icons als Array für die Optionen zurück.
     *
     * @param mixed[] $iconInfos
     *
     * @return mixed[]
     */
    public function getOptions(array $iconInfos): array
    {
        $options = [];

        if (!empty($iconInfos)) {
            foreach ($iconInfos as $name => $ico) {
                if (!empty($ico['label']) && !empty($ico['free'])) {
                    foreach ($ico['free'] as $style) {
                        $options["fa-$style fa-$name"] = "fa-$style fa-$name";
                    }
                }
            }
        }

        return $options;
    }
}
