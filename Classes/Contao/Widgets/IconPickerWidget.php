<?php

/**
 * @since       23.11.2025 - 09:13
 *
 * @author      Patrick Froch <info@netgroup.de>
 *
 * @see         http://www.netgroup.de
 *
 * @copyright   NetGroup GmbH 2025
 */

declare(strict_types=1);

namespace NetGroup\IconToolkit\Classes\Contao\Widgets;

use Contao\System;
use Contao\TextField;
use NetGroup\IconToolkit\Classes\Services\Factories\TemplateFactory;
use NetGroup\IconToolkit\Classes\Services\Helper\AssetHelper;
use NetGroup\IconToolkit\Classes\Services\Helper\IconHelper;

class IconPickerWidget extends TextField
{


    /**
     * Typ des Widgets
     */
    public const TYPE = 'ng_iconpicker';


    /**
     * Template für die Ausgabe des Widgets
     */
    private const PICKER_TPL = 'be_ng_iconpicker';


    /**
     * Erstellt die Optionen aus den JSON Daten.
     *
     * @return array
     */
    public function getOptions(): array
    {
        $container                  = System::getContainer();
        $icoHelper                  = $container->get(IconHelper::class);
        $iconInfos                  = $icoHelper?->parseIconList() ?: [];

        return $icoHelper?->getOptions($iconInfos) ?: [];
    }


    /**
     * {@inheritDoc}
     */
    public function generate(): string
    {
        $ah = System::getContainer()->get(AssetHelper::class);
        $ah?->includeJavaScript();
        $ah?->incldueCss();
        $ah?->includeBeCss();

        $tplFactory                 = System::getContainer()->get(TemplateFactory::class);
        $template                   = $tplFactory?->createBeackendTemplate(self::PICKER_TPL);
        $template->strName          = $this->strName;
        $template->strId            = $this->strId;
        $template->strClass         = $this->strClass ? ' ' . $this->strClass : '';
        $template->varValue         = self::specialcharsValue($this->varValue);
        $template->strAttributes    = $this->getAttributes();
        $template->wizard           = $this->wizard;
        $template->options          = $this->getOptions();

        return $template->parse();
    }


    /**
     * Prüft, ob ein gültigens Icon ausgewählt wurde.
     *
     * @param $varInput
     *
     * @return mixed
     */
    protected function validator($varInput): mixed
    {
        $options    = $this->getOptions();
        $values     = \array_keys($options);
        $err        = $GLOBALS['TL_LANG']['MSC']['ico_error'] ?? 'Bitte wählen Sie ein gültiges Icon aus.';

        if (false === \in_array($varInput, $values, true)) {
            $this->addError($err);
        }

        return parent::validator($varInput);
    }
}
