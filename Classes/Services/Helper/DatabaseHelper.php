<?php

/**
 * @since       02.12.2025 - 08:24
 *
 * @author      Patrick Froch <info@netgroup.de>
 *
 * @see         http://www.netgroup.de
 *
 * @copyright   NetGroup GmbH 2025
 */

declare(strict_types=1);

namespace NetGroup\IconToolkit\Classes\Services\Helper;

use Contao\FilesModel;

class DatabaseHelper
{


    /**
     * Gibt den Pfad zur übergebenen Uuid zurück.
     *
     * @param string $uuid
     *
     * @return string
     */
    public function loadPathByUuid(string $uuid): string
    {
        $row    = FilesModel::findByUuid($uuid) ?: null;
        $path   = $row?->path;

        return !empty($path) ? "/$path" : '';
    }
}
