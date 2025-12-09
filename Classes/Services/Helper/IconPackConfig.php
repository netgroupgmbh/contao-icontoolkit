<?php

/**
 * @since       01.12.2025 - 12:31
 *
 * @author      Patrick Froch <info@netgroup.de>
 *
 * @see         http://www.netgroup.de
 *
 * @copyright   NetGroup GmbH 2025
 */

declare(strict_types=1);

namespace NetGroup\IconToolkit\Classes\Services\Helper;

class IconPackConfig
{


    /**
     * Name des Felds in tl_settings für die CSS-Datei des IconPacks
     */
    public const ICON_PACK_CSS = 'additionalIconPackCss';


    /**
     * Name des Felds in tl_settings für die JSON-Datei des IconPacks
     */
    public const ICON_PACK_JSON = 'additionalIconPackJson';


    /**
     * Pfad zur CSS-Datei der freien Version von Font Awesome
     * (exkl. public/)
     */
    public const DEFAULT_ICON_PACK_CSS = '/bundles/netgroupicontoolkit/fontawesome-free-7.1.0-web/css/all.min.css';


    /**
     * Pfad zur JSON-Datei der freien Version von Font Awesome
     * (inkl. public/)
     */
    public const DEFAULT_ICON_PACK_JSON = '/public/bundles/netgroupicontoolkit/fontawesome-free-7.1.0-web/metadata/icons.json';


    /**
     * @param ConfigHelper   $configHelper
     * @param DatabaseHelper $db
     */
    public function __construct(private readonly ConfigHelper $configHelper, private readonly DatabaseHelper $db)
    {
    }


    /**
     * Gibt den Pfad zur Css Datei des IconPacks zurück.
     *
     * @return string
     */
    public function getIconPackCss(): string
    {
        $uuid = $this->configHelper->get(self::ICON_PACK_CSS);

        return $this->db->loadPathByUuid($uuid) ?: self::DEFAULT_ICON_PACK_CSS;
    }


    /**
     * Gibt den Pfad zur Json Datei des IconPacks zurück.
     *
     * @return string
     */
    public function getIconPackJson(): string
    {
        $uuid = $this->configHelper->get(self::ICON_PACK_JSON);

        return $this->db->loadPathByUuid($uuid) ?: self::DEFAULT_ICON_PACK_JSON;
    }
}
