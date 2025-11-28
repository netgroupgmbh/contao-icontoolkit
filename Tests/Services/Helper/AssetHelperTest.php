<?php

/**
 * @since       28.11.2025 - 08:35
 *
 * @author      Patrick Froch <info@netgroup.de>
 *
 * @see         http://www.netgroup.de
 *
 * @copyright   NetGroup GmbH 2025
 */

declare(strict_types=1);

namespace NetGroup\IconToolkit\Tests\Services\Helper;

use NetGroup\IconToolkit\Classes\Services\Helper\AssetHelper;
use PHPUnit\Framework\TestCase;

class AssetHelperTest extends TestCase
{


    /**
     * @var AssetHelper
     */
    private AssetHelper $assetHelper;

    protected function setUp(): void
    {
        $this->assetHelper = new AssetHelper();
    }


    public function testIncldueCssSetCssIfGlobalArrayIsEmpty(): void
    {
        $GLOBALS['TL_CSS'] = [];
        $this->assetHelper->incldueCss();
        $this->assertSame($this->assetHelper::CSS, $GLOBALS['TL_CSS']);
    }


    public function testIncldueCssSetCssIfCssIsNotInTheGlobalArray(): void
    {
        $GLOBALS['TL_CSS'] = ['/tmp/test.css'];
        $this->assetHelper->incldueCss();
        $this->assertSame(['/tmp/test.css', $this->assetHelper::CSS[0]], $GLOBALS['TL_CSS']);
    }


    public function testIncldueCssDoNotSetCssIfCssIsInTheGlobalArray(): void
    {
        $GLOBALS['TL_CSS'] = $this->assetHelper::CSS;
        $this->assetHelper->incldueCss();
        $this->assertSame($this->assetHelper::CSS, $GLOBALS['TL_CSS']);
    }


    public function testIncldueBeCssSetCssIfGlobalArrayIsEmpty(): void
    {
        $GLOBALS['TL_CSS'] = [];
        $this->assetHelper->includeBeCss();
        $this->assertSame($this->assetHelper::BE_CSS, $GLOBALS['TL_CSS']);
    }


    public function testIncldueBeCssSetCssIfCssIsNotInTheGlobalArray(): void
    {
        $GLOBALS['TL_CSS'] = ['/tmp/test.css'];
        $this->assetHelper->includeBeCss();
        $this->assertSame(['/tmp/test.css', $this->assetHelper::BE_CSS[0]], $GLOBALS['TL_CSS']);
    }


    public function testIncldueBeCssDoNotSetCssIfCssIsInTheGlobalArray(): void
    {
        $GLOBALS['TL_CSS'] = $this->assetHelper::BE_CSS;
        $this->assetHelper->includeBeCss();
        $this->assertSame($this->assetHelper::BE_CSS, $GLOBALS['TL_CSS']);
    }


    public function testIncldueJavaScriptSetJsIfGlobalArrayIsEmpty(): void
    {
        $GLOBALS['TL_JAVASCRIPT'] = [];
        $this->assetHelper->includeJavaScript();
        $this->assertSame($this->assetHelper::JS, $GLOBALS['TL_JAVASCRIPT']);
    }


    public function testIncldueJavaScriptSetCssIfJsIsNotInTheGlobalArray(): void
    {
        $GLOBALS['TL_JAVASCRIPT'] = ['/tmp/test.js'];
        $this->assetHelper->includeJavaScript();
        $this->assertSame(['/tmp/test.js', $this->assetHelper::JS[0]], $GLOBALS['TL_JAVASCRIPT']);
    }


    public function testIncldueBeCssDoNotSetCssIfJsIsInTheGlobalArray(): void
    {
        $GLOBALS['TL_JAVASCRIPT'] = $this->assetHelper::JS;
        $this->assetHelper->includeJavaScript();
        $this->assertSame($this->assetHelper::JS, $GLOBALS['TL_JAVASCRIPT']);
    }
}
