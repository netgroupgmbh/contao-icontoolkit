<?php

/**
 * @since       26.11.2025 - 16:36
 *
 * @author      Patrick Froch <info@netgroup.de>
 *
 * @see         http://www.netgroup.de
 *
 * @copyright   NetGroup GmbH 2025
 */

declare(strict_types=1);

namespace NetGroup\IconToolkit\Classes\Services\Helper;

class FileAbstractionHelper
{


    /**
     * @param string $path
     *
     * @return string
     */
    public function getContents(string $path): string
    {
        return \file_get_contents($path) ?: '';
    }
}
