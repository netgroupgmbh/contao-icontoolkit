<?php

/**
 * @since       02.12.2025 - 08:51
 *
 * @author      Patrick Froch <info@netgroup.de>
 *
 * @see         http://www.netgroup.de
 *
 * @copyright   NetGroup GmbH 2025
 */

declare(strict_types=1);

use NetGroup\IconToolkit\Classes\Services\Helper\IconPackConfig;

/**
 * Set Tablename
 */
$table = 'tl_settings';


/**
 * Fields
 */
$GLOBALS['TL_LANG'][$table][IconPackConfig::ICON_PACK_CSS]  = ['CSS-Datei des Icon Packs', 'Bitte wählen Sie die CSS-Datei des Icon Packs aus.'];
$GLOBALS['TL_LANG'][$table][IconPackConfig::ICON_PACK_JSON] = ['JSON-Datei des Icon Packs', 'Bitte wählen Sie die JSON-Datei mit den Definitionen der Icons des Icon Packs aus. (Die Datei muss den geleichen Aufbau haben, wie die icons.json von Font Awesome.)'];


/**
 * Legends
 */
$GLOBALS['TL_LANG'][$table]['icontoolkit_legend']   = 'NetGroup Icon Toolkit';
