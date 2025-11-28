<?php

/**
 * @since       22.07.2025 - 09:51
 *
 * @author      Patrick Froch <info@netgroup.de>
 *
 * @see         http://www.netgroup.de
 *
 * @copyright   NetGroup GmbH 2025
 */

declare(strict_types=1);

namespace NetGroup\IconToolkit\Classes\Services\Helper;

class AssetHelper
{


    public const CSS = [
        '/bundles/netgroupicontoolkit/fontawesome-free-7.1.0-web/css/all.min.css'
    ];


    public const BE_CSS = [
        '/bundles/netgroupicontoolkit/custom/icon_picker_widget.css'
    ];


    public const JS = [
        '/bundles/netgroupicontoolkit/custom/icon_picker_widget.js'
    ];


    /**
     * Bindet das CSS ein.
     *
     * @return void
     */
    public function incldueCss(): void
    {
        foreach (self::CSS as $css) {
            if (empty($GLOBALS['TL_CSS']) || !\in_array($css, $GLOBALS['TL_CSS'], true)) {
                $GLOBALS['TL_CSS'][] = $css;
            }
        }
    }


    /**
     * Bindet das CSS für das Backend Widget ein.
     *
     * @return void
     */
    public function includeBeCss(): void
    {
        foreach (self::BE_CSS as $css) {
            if (empty($GLOBALS['TL_CSS']) || !\in_array($css, $GLOBALS['TL_CSS'], true)) {
                $GLOBALS['TL_CSS'][] = $css;
            }
        }
    }


    /**
     * Bindet das JavaScript für das Backend Widget ein.
     *
     * @return void
     */
    public function includeJavaScript(): void
    {
        foreach (self::JS as $js) {
            if (empty($GLOBALS['TL_JAVASCRIPT']) || !\in_array($js, $GLOBALS['TL_JAVASCRIPT'], true)) {
                $GLOBALS['TL_JAVASCRIPT'][] = $js;
            }
        }
    }
}
