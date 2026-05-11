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

use Contao\StringUtil;
use Contao\System;
use Contao\TextField;
use NetGroup\IconToolkit\Classes\Services\Factories\TemplateFactory;
use NetGroup\IconToolkit\Classes\Services\Helper\AssetHelper;
use NetGroup\IconToolkit\Classes\Services\Helper\IconHelper;
use NetGroup\IconToolkit\Classes\Services\Helper\ValueHelper;

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
     * @return string
     *
     * @throws \Doctrine\DBAL\Exception
     * @throws \JsonException
     */
    public function generate(): string
    {
        /** @var IconHelper|null $icoHelper */
        $icoHelper      = System::getContainer()->get(IconHelper::class);
        /** @var AssetHelper|null $ah */
        $ah             = System::getContainer()->get(AssetHelper::class);
        /** @var TemplateFactory|null $tplFactory */
        $tplFactory     = System::getContainer()->get(TemplateFactory::class);
        /** @var ValueHelper|null $valueHelper */
        $valueHelper    = System::getContainer()->get(ValueHelper::class);
        $iconInfos      = $icoHelper?->parseIconList() ?: [];

        $ah?->includeJavaScript();
        $ah?->incldueCss();
        $ah?->includeBeCss();

        $value      = $valueHelper?->getStringValue($this->varValue) ?: '';
        $iconStyle  = $this->getIconStyle($value);
        $template   = $tplFactory?->createBeackendTemplate(self::PICKER_TPL);

        if (null !== $template) {
            $template->strName          = $this->strName;
            $template->strId            = $this->strId;
            $template->strClass         = $this->strClass ? ' ' . $this->strClass : '';
            $template->varValue         = StringUtil::specialchars($value);
            $template->strAttributes    = $this->getAttributes();
            $template->wizard           = $this->wizard;
            $template->options          = $icoHelper?->getOptions($iconInfos, $iconStyle, '') ?: [];
            $template->iconStyle        = $iconStyle;
            $template->iconStyles       = $icoHelper?->getStyles($iconInfos) ?: [];

            return $template->parse();
        }

        return '';
    }


    /**
     * Gibt den Style des gewählen Icons zurück.
     *
     * @param string $value
     *
     * @return string
     */
    public function getIconStyle(string $value): string
    {
        $iconStyle = StringUtil::specialchars($value);
        $iconStyle = \str_replace('fa-', '', $iconStyle);
        $iconStyle = \explode(' ', $iconStyle);

        return !empty($iconStyle[0]) ? $iconStyle[0] : 'solid';
    }


    /**
     * Prüft, ob ein gültigens Icon ausgewählt wurde.
     *
     * @param $varInput
     *
     * @return mixed
     *
     * @throws \Doctrine\DBAL\Exception
     * @throws \JsonException
     */
    protected function validator($varInput): mixed
    {
        /** @var IconHelper|null $icoHelper */
        $icoHelper      = System::getContainer()->get(IconHelper::class);
        /** @var ValueHelper|null $valueHelper */
        $valueHelper    = System::getContainer()->get(ValueHelper::class);
        $value          = $valueHelper?->getStringValue($varInput) ?: '';
        $iconStyle      = $this->getIconStyle($value);
        $iconInfos      = $icoHelper?->parseIconList() ?: [];
        $options        = $icoHelper?->getOptions($iconInfos, $iconStyle) ?: [];
        $values         = \array_keys($options);
        /** @var array{TL_LANG: array<string, mixed>} $GLOBALS */
        $err            = $GLOBALS['TL_LANG']['MSC']['ico_error'] ?? ''; // @phpstan-ignore offsetAccess.nonOffsetAccessible

        if (false === \in_array($varInput, $values, true)) {
            if (false === \is_string($err) || empty($err)) {
                $err = 'Bitte wählen Sie ein gültiges Icon aus.';
            }

            $this->addError($err);
        }

        return parent::validator($varInput);
    }
}
