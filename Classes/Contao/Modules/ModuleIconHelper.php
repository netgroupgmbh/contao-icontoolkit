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

namespace NetGroup\IconToolkit\Classes\Contao\Modules;

use Contao\BackendTemplate;
use Contao\Module;
use Contao\System;
use Esit\Scopehelper\Classes\Services\Helper\ScopeHelper;
use NetGroup\IconToolkit\Classes\Services\Helper\AssetHelper;

class ModuleIconHelper extends Module
{


    /**
     * Type des Modules
     */
    public const TYPE = 'icon_helper';


    /**
     * Template
     *
     * @var string
     */
    protected $strTemplate = 'mod_ng_iconhelper';


    /**
     * Generate module
     */
    public function generate(): string
    {
        /** @var ScopeHelper|null $sh */
        $sh = System::getContainer()->get(ScopeHelper::class);

        if (true === $sh?->isBackend()) {
            $href                   = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;
            $objTemplate            = new BackendTemplate('be_wildcard');
            $objTemplate->wildcard  = '### FRONTEND MODUL ###';
            $objTemplate->title     = $this->headline;
            $objTemplate->id        = $this->id;
            $objTemplate->link      = $this->name;
            $objTemplate->href      = $href;

            return $objTemplate->parse();
        }

        if (true === $sh?->isFrontend()) {
            /** @var AssetHelper|null $ah */
            $ah = System::getContainer()->get(AssetHelper::class);
            $ah?->incldueCss();
        }

        return parent::generate();
    }


    /**
     * Generate the module
     */
    protected function compile(): void
    {
    }
}
