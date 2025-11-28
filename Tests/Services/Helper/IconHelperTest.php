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

use NetGroup\IconToolkit\Classes\Services\Factories\FinderFactory;
use NetGroup\IconToolkit\Classes\Services\Helper\FileAbstractionHelper;
use NetGroup\IconToolkit\Classes\Services\Helper\IconHelper;
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

        $this->filesystem       = $this->getMockBuilder(Filesystem::class)
                                       ->getMock();


        $this->iconHelper       = new IconHelper('/project', '/icons.json', $this->finderFactory, $this->file);
    }


    /**
     * @return void
     *
     * @throws \JsonException
     */
    public function testParseIconListReturnsValidData(): void
    {
        // Anordnen
        $path             = '/project/icons.json';
        $jsonContent      = '{"home":{"label":"Home","free":["solid"]}}';
        $expected         = [
            'home' => [
                'label' => 'Home',
                'free'  => ['solid']
            ]
        ];

        $this->finderFactory->method('createFileSystem')
                            ->willReturn($this->filesystem);

        $this->filesystem->method('exists')
                         ->with($path)
                         ->willReturn(true);

        $this->file->method('getContents')
                   ->with($path)
                   ->willReturn($jsonContent);

        $rtn = $this->iconHelper->parseIconList();

        $this->assertEquals($expected, $rtn);
    }


    /**
     * @return void
     *
     * @throws \JsonException
     */
    public function testParseIconListReturnsEmptyWhenFileNotFound(): void
    {
        // Anordnen
        $path = '/project/icons.json';

        $this->finderFactory->method('createFileSystem')
                            ->willReturn($this->filesystem);

        $this->filesystem->method('exists')
                         ->with($path)
                         ->willReturn(false);

        $rtn = $this->iconHelper->parseIconList();

        $this->assertEquals([], $rtn);
    }


    /**
     * @return void
     *
     * @throws \JsonException
     */
    public function testParseIconListReturnsEmptyWhenContentIsEmpty(): void
    {
        // Anordnen
        $path   = '/project/icons.json';
        $empty  = '';

        $this->finderFactory->method('createFileSystem')
                            ->willReturn($this->filesystem);

        $this->filesystem->method('exists')
                         ->with($path)
                         ->willReturn(true);

        $this->file->method('getContents')
                   ->with($path)
                   ->willReturn($empty);

        $rtn = $this->iconHelper->parseIconList();

        $this->assertEquals([], $rtn);
    }


    public function testGetOptionsReturnsCorrectOptions(): void
    {
        // Anordnen
        $iconInfos = [
            'home' => [
                'label' => 'Home Icon',
                'free'  => ['solid', 'regular']
            ]
        ];

        $expected = [
            'fa-solid fa-home'   => 'fa-solid fa-home',
            'fa-regular fa-home' => 'fa-regular fa-home'
        ];

        $rtn = $this->iconHelper->getOptions($iconInfos);

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
                'label' => '',
                'free'  => []
            ]
        ];

        $rtn = $this->iconHelper->getOptions($invalidIconInfos);

        $this->assertEquals([], $rtn);
    }
}
