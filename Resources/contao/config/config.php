<?php

/**
 * @since       28.11.2025 - 06:07
 *
 * @author      Patrick Froch <info@netgroup.de>
 *
 * @see         http://www.netgroup.de
 *
 * @copyright   NetGroup GmbH 2025
 */
declare(strict_types=1);

use NetGroup\IconToolkit\Classes\Contao\Modules\ModuleIconHelper;
use NetGroup\IconToolkit\Classes\Contao\Widgets\IconPickerWidget;

$GLOBALS['FE_MOD']['miscellaneous'][ModuleIconHelper::TYPE] = ModuleIconHelper::class;
$GLOBALS['BE_FFL']['ng_iconpicker']                         = IconPickerWidget::class;