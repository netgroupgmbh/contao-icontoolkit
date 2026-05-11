<?php

/**
 * @since       11.05.2026 - 08:03
 *
 * @author      Patrick Froch <info@netgroup.de>
 *
 * @see         http://www.netgroup.de
 *
 * @copyright   NetGroup GmbH 2026
 */

declare(strict_types=1);

namespace NetGroup\IconToolkit\Tests\Services\Helper;

use NetGroup\IconToolkit\Classes\Services\Helper\ValueHelper;
use PHPUnit\Framework\TestCase;

class ValueHelperTest extends TestCase
{


    /**
     * @var ValueHelper
     */
    private ValueHelper $helper;


    protected function setUp(): void
    {
        $this->helper = new ValueHelper();
    }


    public function testGetStringValueReturnsStringIfValueIsAString(): void
    {
        $value = 'TEST';

        $this->assertIsString($this->helper->getStringValue($value));
        $this->assertSame($value, $this->helper->getStringValue($value));
    }


    public function testGetStringValueReturnsStringIfValueIsAInteger(): void
    {
        $value = 12;

        $this->assertIsString($this->helper->getStringValue($value));
        $this->assertSame((string) $value, $this->helper->getStringValue($value));
    }


    public function testGetStringValueReturnsStringIfValueIsAFloat(): void
    {
        $value = 12.34;

        $this->assertIsString($this->helper->getStringValue($value));
        $this->assertSame((string) $value, $this->helper->getStringValue($value));
    }


    public function testGetStringValueReturnsStringIfValueIsBool(): void
    {
        $value = true;

        $this->assertIsString($this->helper->getStringValue($value));
        $this->assertSame((string) $value, $this->helper->getStringValue($value));
    }


    public function testGetStringValueReturnsEmptyStringIfValueIsAnArray(): void
    {
        $value = ['test'];

        $this->assertIsString($this->helper->getStringValue($value));
        $this->assertEmpty($this->helper->getStringValue($value));
    }


    public function testGetStringValueReturnsEmptyStringIfValueIsAnObject(): void
    {
        $value = new \stdClass();

        $this->assertIsString($this->helper->getStringValue($value));
        $this->assertEmpty($this->helper->getStringValue($value));
    }
}
