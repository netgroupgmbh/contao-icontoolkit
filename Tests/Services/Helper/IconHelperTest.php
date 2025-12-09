<?php

/**
 * @since       28.11.2025 - 08:42
 *
 * @author      Patrick Froch <info@netgroup.de>
 *
 * @see         http://www.netgroup.de
 *
 * @copyright   NetGroup GmbH 2025
 */

declare(strict_types=1);

namespace NetGroup\IconToolkit\Tests\Services\Helper;

use Doctrine\DBAL\Exception;
use NetGroup\IconToolkit\Classes\Services\Factories\FinderFactory;
use NetGroup\IconToolkit\Classes\Services\Helper\FileAbstractionHelper;
use NetGroup\IconToolkit\Classes\Services\Helper\IconHelper;
use NetGroup\IconToolkit\Classes\Services\Helper\IconPackConfig;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Filesystem\Filesystem;

class IconHelperTest extends TestCase
{

    /**
     * @var FinderFactory
     */
    private $finderFactory;



    /**
     * @var FileAbstractionHelper
     */
    private $file;


    /**
     * @var (IconPackConfig&MockObject)|MockObject
     */
    private $iconConfig;



    /**
     * @var mixed
     */
    private $filesystem;



    /**
     * @var IconHelper
     */
    private $iconHelper;



    protected function setUp(): void
    {
        $this->finderFactory    = $this->getMockBuilder(FinderFactory::class)
                                       ->disableOriginalConstructor()
                                       ->getMock();

        $this->file             = $this->getMockBuilder(FileAbstractionHelper::class)
                                       ->disableOriginalConstructor()
                                       ->getMock();

        $this->iconConfig       = $this->getMockBuilder(IconPackConfig::class)
                                       ->disableOriginalConstructor()
                                       ->getMock();

        $this->filesystem       = $this->getMockBuilder(Filesystem::class)
                                       ->getMock();


        $this->iconHelper       = new IconHelper('/project', $this->finderFactory, $this->file, $this->iconConfig);
    }


    /**
     * @return void
     *
     * @throws \JsonException
     * @throws Exception
     */
    public function testParseIconListReturnsValidData(): void
    {
        // Anordnen
        $path             = '/public/icons.json';
        $jsonContent      = '{"home":{"label":"Home","free":["solid"]}}';
        $expected         = [
            'home' => [
                'label' => 'Home',
                'free'  => ['solid']
            ]
        ];

        $this->iconConfig->expects($this->once())
                         ->method('getIconPackJson')
                         ->willReturn($path);

        $this->finderFactory->method('createFileSystem')
                            ->willReturn($this->filesystem);

        $this->filesystem->method('exists')
                         ->with("/project$path")
                         ->willReturn(true);

        $this->file->method('getContents')
                   ->with("/project$path")
                   ->willReturn($jsonContent);

        $rtn = $this->iconHelper->parseIconList();

        $this->assertEquals($expected, $rtn);
    }


    /**
     * @return void
     *
     * @throws \JsonException
     * @throws Exception
     */
    public function testParseIconListReturnsEmptyWhenFileNotFound(): void
    {
        // Anordnen
        $path = '/public/icons.json';

        $this->iconConfig->expects($this->once())
                         ->method('getIconPackJson')
                         ->willReturn($path);

        $this->finderFactory->method('createFileSystem')
                            ->willReturn($this->filesystem);

        $this->filesystem->method('exists')
                         ->with("/project$path")
                         ->willReturn(false);

        $rtn = $this->iconHelper->parseIconList();

        $this->assertEquals([], $rtn);
    }


    /**
     * @return void
     *
     * @throws \JsonException
     * @throws Exception
     */
    public function testParseIconListReturnsEmptyWhenContentIsEmpty(): void
    {
        // Anordnen
        $path   = '/project/icons.json';
        $empty  = '';

        $this->iconConfig->expects($this->once())
                         ->method('getIconPackJson')
                         ->willReturn($path);

        $this->finderFactory->method('createFileSystem')
                            ->willReturn($this->filesystem);

        $this->filesystem->method('exists')
                         ->with("/project$path")
                         ->willReturn(true);

        $this->file->method('getContents')
                   ->with("/project$path")
                   ->willReturn($empty);

        $rtn = $this->iconHelper->parseIconList();

        $this->assertEquals([], $rtn);
    }


    public function testGetOptionsReturnsCorrectOptions(): void
    {
        // Anordnen
        $iconInfos = [
            'home' => [
                'label'     => 'Home Icon',
                'styles'    => ['solid', 'regular']
            ]
        ];

        $expected = [
            'fa-regular fa-home' => 'fa-regular fa-home'
        ];

        $rtn = $this->iconHelper->getOptions($iconInfos, 'regular');

        $this->assertEquals($expected, $rtn);
    }



    /**
     * Test: getOptions gibt leeres Array zurück, wenn keine gültigen Icons existieren.
     */
    public function testGetOptionsReturnsEmptyForInvalidIconInfo(): void
    {
        // Anordnen
        $invalidIconInfos = [
            'broken' => [
                'label'     => '',
                'styles'    => []
            ]
        ];

        $rtn = $this->iconHelper->getOptions($invalidIconInfos);

        $this->assertEquals([], $rtn);
    }


    public function testGetStyleReturnEmptyArrayIfNoIconInfosFound(): void
    {
        $iconInfos  = [];

        $this->assertEmpty($this->iconHelper->getStyles($iconInfos));
    }


    public function testGetStyleReturnEmptyArrayIfNoStylesFound(): void
    {
        $iconInfos  = [
            'home' => [
                'label'     => 'Home Icon',
                'styles'    => []
            ]
        ];

        $this->assertEmpty($this->iconHelper->getStyles($iconInfos));
    }


    public function testGetStyleReturnStyleIfFound(): void
    {
        $expected   = ['solid', 'regular'];
        $iconInfos  = [
            'home' => [
                'label'     => 'Home Icon',
                'styles'    => ['solid', 'regular']
            ]
        ];

        $this->assertSame($expected, $this->iconHelper->getStyles($iconInfos));
    }
}
