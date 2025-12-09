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

use Doctrine\DBAL\Exception;
use NetGroup\IconToolkit\Classes\Services\Factories\FinderFactory;

class IconHelper
{


    /**
     * @param string                $projectDir
     * @param FinderFactory         $finderFactory
     * @param FileAbstractionHelper $file
     * @param IconPackConfig        $config
     */
    public function __construct(
        private readonly string $projectDir,
        private readonly FinderFactory $finderFactory,
        private readonly FileAbstractionHelper $file,
        private readonly IconPackConfig $config
    ) {
    }


    /**
     * Gibt die Informationen der Icons zurück
     *
     * @return mixed[]
     *
     * @throws \JsonException
     * @throws Exception
     */
    public function parseIconList(): array
    {
        $fs     = $this->finderFactory->createFileSystem();
        $json   = $this->config->getIconPackJson();

        if ($fs->exists($this->projectDir . $json)) {
            $contnet = $this->file->getContents($this->projectDir . $json);

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
     * @param string  $style
     * @param string  $search
     *
     * @return mixed[]
     */
    public function getOptions(array $iconInfos, string $style = 'solid', string $search = ''): array
    {
        $options = [];

        if (!empty($iconInfos)) {
            foreach ($iconInfos as $name => $ico) {
                if (!empty($ico['styles']) && true === \in_array($style, $ico['styles'], true)) {
                    if (empty($search) || \str_contains((string) $name, $search)) {
                        $options["fa-$style fa-$name"] = "fa-$style fa-$name";
                    }
                }
            }
        }

        return $options;
    }


    /**
     * Gibt die Styles der Icons zurück.
     *
     * @param mixed[] $iconInfos
     *
     * @return mixed[]
     */
    public function getStyles(array $iconInfos): array
    {
        $styles = [];

        if (!empty($iconInfos)) {
            foreach ($iconInfos as $ico) {
                if (!empty($ico['styles'])) {
                    foreach ($ico['styles'] as $style) {
                        if (false === \in_array($style, $styles, true)) {
                            $styles[] = $style;
                        }
                    }

                }
            }
        }

        return $styles;
    }
}
