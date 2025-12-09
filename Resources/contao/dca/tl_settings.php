<?php

/**
 * @since       01.12.2025 - 12:00
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
 * Set Tablename: tl_settings
 */
$table = 'tl_settings';

/* Palettes */
$GLOBALS['TL_DCA'][$table]['palettes']['default'] .= ';{icontoolkit_legend},' . IconPackConfig::ICON_PACK_CSS . ',' . IconPackConfig::ICON_PACK_JSON;


/* Fields */
$GLOBALS['TL_DCA'][$table]['fields'][IconPackConfig::ICON_PACK_CSS] = [
    'label'                 => &$GLOBALS['TL_LANG'][$table][IconPackConfig::ICON_PACK_CSS],
    'exclude'               => true,
    'inputType'             => 'fileTree',
    'eval'                  => ['fieldType'=>'radio', 'files'=>true, 'filesOnly'=>true, 'tl_class'=>'w50', 'extensions'=>'css'],
];

$GLOBALS['TL_DCA'][$table]['fields'][IconPackConfig::ICON_PACK_JSON] = [
    'label'                 => &$GLOBALS['TL_LANG'][$table][IconPackConfig::ICON_PACK_JSON],
    'exclude'               => true,
    'inputType'             => 'fileTree',
    'eval'                  => ['fieldType'=>'radio', 'files'=>true, 'filesOnly'=>true, 'tl_class'=>'w50', 'extensions'=>'json'],
];
