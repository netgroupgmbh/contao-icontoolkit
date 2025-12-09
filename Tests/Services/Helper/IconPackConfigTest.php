<?php

/**
 * @since       09.12.2025 - 14:19
 *
 * @author      Patrick Froch <info@netgroup.de>
 *
 * @see         http://www.netgroup.de
 *
 * @copyright   NetGroup GmbH 2025
 */

declare(strict_types=1);

namespace NetGroup\IconToolkit\Tests\Services\Helper;

use NetGroup\IconToolkit\Classes\Services\Helper\ConfigHelper;
use NetGroup\IconToolkit\Classes\Services\Helper\DatabaseHelper;
use NetGroup\IconToolkit\Classes\Services\Helper\IconPackConfig;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class IconPackConfigTest extends TestCase
{


    /**
     * @var (ConfigHelper&MockObject)|MockObject
     */
    private $configHelper;


    /**
     * @var (DatabaseHelper&MockObject)|MockObject
     */
    private $db;


    /**
     * @var IconPackConfig
     */
    private IconPackConfig $helper;


    protected function setUp(): void
    {
        $this->configHelper     = $this->getMockBuilder(ConfigHelper::class)
                                       ->disableOriginalConstructor()
                                       ->getMock();

        $this->db               = $this->getMockBuilder(DatabaseHelper::class)
                                       ->disableOriginalConstructor()
                                       ->getMock();

        $this->helper = new IconPackConfig($this->configHelper, $this->db);
    }


    public function testGetIconPackCssReturnDefaultPathIfSettingsPathIsNotFound(): void
    {
        $uuid = \uniqid('', true);
        $path = '';

        $this->configHelper->expects($this->once())
                           ->method('get')
                           ->with($this->helper::ICON_PACK_CSS)
                           ->willReturn($uuid);

        $this->db->expects($this->once())
                 ->method('loadPathByUuid')
                 ->with($uuid)
                 ->willReturn($path);

        $this->assertSame($this->helper::DEFAULT_ICON_PACK_CSS, $this->helper->getIconPackCss());
    }


    public function testGetIconPackCssReturnPathFromSettingsIfSet(): void
    {
        $uuid = \uniqid('', true);
        $path = '/project/tmp/test.css';

        $this->configHelper->expects($this->once())
                           ->method('get')
                           ->with($this->helper::ICON_PACK_CSS)
                           ->willReturn($uuid);

        $this->db->expects($this->once())
                 ->method('loadPathByUuid')
                 ->with($uuid)
                 ->willReturn($path);

        $this->assertSame($path, $this->helper->getIconPackCss());
    }


    public function testGetIconPackJsonReturnDefaultPathIfSettingsPathIsNotFound(): void
    {
        $uuid = \uniqid('', true);
        $path = '';

        $this->configHelper->expects($this->once())
                           ->method('get')
                           ->with($this->helper::ICON_PACK_JSON)
                           ->willReturn($uuid);

        $this->db->expects($this->once())
                 ->method('loadPathByUuid')
                 ->with($uuid)
                 ->willReturn($path);

        $this->assertSame($this->helper::DEFAULT_ICON_PACK_JSON, $this->helper->getIconPackJson());
    }


    public function testGetIconPackJsonReturnPathFromSettingsIfSet(): void
    {
        $uuid = \uniqid('', true);
        $path = '/project/tmp/test.json';

        $this->configHelper->expects($this->once())
                           ->method('get')
                           ->with($this->helper::ICON_PACK_JSON)
                           ->willReturn($uuid);

        $this->db->expects($this->once())
                 ->method('loadPathByUuid')
                 ->with($uuid)
                 ->willReturn($path);

        $this->assertSame($path, $this->helper->getIconPackJson());
    }
}
