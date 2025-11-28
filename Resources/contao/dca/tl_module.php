<?php

/**
 * @since       28.11.2025 - 06:17
 *
 * @author      Patrick Froch <info@netgroup.de>
 *
 * @see         http://www.netgroup.de
 *
 * @copyright   NetGroup GmbH 2025
 */

declare(strict_types=1);

use NetGroup\IconToolkit\Classes\Contao\Modules\ModuleIconHelper;

/**
 * Set Tablename: tl_module
 */
$table = 'tl_module';

/* global_operations
$GLOBALS['TL_DCA'][$table]['list']['global_operations'] = [
   'all' => [
       'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
       'href'                => 'act=select',
       'class'               => 'header_edit_all',
       'attributes'          => 'onclick="Backend.getScrollOffset();" accesskey="e"'
   ]
];

/* operations
$GLOBALS['TL_DCA'][$table]['list']['operations']['delete'] = [
    'label'             => &$GLOBALS['TL_LANG'][$table]['delete'],
    'href'              => 'act=delete',
    'icon'              => 'delete.svg',
    'attributes'        => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
];

/* slectors
$GLOBALS['TL_DCA'][$table]['palettes']['__selector__'][] = 'SUBFIELD';

/* Palettes */
$GLOBALS['TL_DCA'][$table]['palettes'][ModuleIconHelper::TYPE] = '{title_legend},name,type;{protected_legend:hide},protected;';

/* subpalettes
$GLOBALS['TL_DCA'][$table]['subpalettes']['SUBFIELD'] = 'FIELDS';

/* Fields
$GLOBALS['TL_DCA'][$table]['fields']['title'] = [
    'label'                 => &$GLOBALS['TL_LANG'][$table]['title'],
    'exclude'               => true,
    'inputType'             => 'text',
    'eval'                  => ['mandatory'=>true, 'maxlength'=>255],
    'sql'                   => "varchar(255) NOT NULL default ''"
];
/**/
