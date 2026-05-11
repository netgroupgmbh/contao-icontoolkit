<?php

/**
 * @since       01.12.2025 - 12:28
 *
 * @author      Patrick Froch <info@netgroup.de>
 *
 * @see         http://www.netgroup.de
 *
 * @copyright   NetGroup GmbH 2025
 */

declare(strict_types=1);

namespace NetGroup\IconToolkit\Classes\Services\Helper;

use Contao\Config;

class ConfigHelper
{


    /**
     * Gibt einen Wert aus der Konfiguration zurück.
     *
     * @param string $name
     *
     * @return string
     *
     * @codeCoverageIgnore
     */
    public function get(string $name): string
    {
        $value   = Config::get($name) ?: '';

        if (true === \is_string($value)) {
            return $value;
        }

        if (is_int($value) || is_float($value) || is_bool($value)) {
            return (string) $value;
        }

        return '';
    }
}
