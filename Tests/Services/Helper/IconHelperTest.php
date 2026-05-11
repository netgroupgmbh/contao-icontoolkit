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
use PHPUnit\Framework\Attributes\AllowMockObjectsWithoutExpectations;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Filesystem\Filesystem;

#[AllowMockObjectsWithoutExpectations]
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
     * Test: parseIconList gibt gültige Daten zurück, wenn die JSON-Datei existiert und Inhalt hat.
     *
     * @return void
     *
     * @throws \JsonException
     * @throws Exception
     */
    public function testParseIconListReturnsValidData(): void
    {
        // Anordnen
        $path           = '/public/icons.json';
        $jsonContent    = '{"home":{"label":"Home","free":["solid"]}}';
        $expected       = [
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

        // Ausführen
        $rtn = $this->iconHelper->parseIconList();

        // Assert
        $this->assertEquals($expected, $rtn);
    }


    /**
     * Test: parseIconList gibt leeres Array zurück, wenn die Datei nicht existiert.
     *
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

        // Ausführen
        $rtn = $this->iconHelper->parseIconList();

        // Assert
        $this->assertEquals([], $rtn);
    }


    /**
     * Test: parseIconList gibt leeres Array zurück, wenn der Dateiinhalt leer ist.
     *
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

        // Ausführen
        $rtn = $this->iconHelper->parseIconList();

        // Assert
        $this->assertEquals([], $rtn);
    }


    /**
     * Test: getOptions gibt korrekte Optionen für den angegebenen Style zurück.
     *
     * @return void
     */
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

        // Ausführen
        $rtn = $this->iconHelper->getOptions($iconInfos, 'regular');

        // Assert
        $this->assertEquals($expected, $rtn);
    }


    /**
     * Test: getOptions gibt leeres Array zurück, wenn keine gültigen Icons existieren.
     *
     * @return void
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

        // Ausführen
        $rtn = $this->iconHelper->getOptions($invalidIconInfos);

        // Assert
        $this->assertEquals([], $rtn);
    }


    /**
     * Test: getOptions gibt leeres Array zurück, wenn $iconInfos leer ist.
     *
     * @return void
     */
    public function testGetOptionsReturnsEmptyArrayWhenIconInfosIsEmpty(): void
    {
        // Ausführen
        $rtn = $this->iconHelper->getOptions([]);

        // Assert
        $this->assertEquals([], $rtn);
    }


    /**
     * Test: getOptions filtert Icons korrekt nach dem Suchbegriff.
     *
     * @return void
     */
    public function testGetOptionsFiltersIconsBySearchTerm(): void
    {
        // Anordnen
        $iconInfos = [
            'home'    => [
                'label'     => 'Home Icon',
                'styles'    => ['solid']
            ],
            'heart'   => [
                'label'     => 'Heart Icon',
                'styles'    => ['solid']
            ],
            'star'    => [
                'label'     => 'Star Icon',
                'styles'    => ['solid']
            ]
        ];

        $expected = [
            'fa-solid fa-home' => 'fa-solid fa-home'
        ];

        // Ausführen
        $rtn = $this->iconHelper->getOptions($iconInfos, 'solid', 'home');

        // Assert
        $this->assertEquals($expected, $rtn);
    }


    /**
     * Test: getOptions gibt alle Icons zurück, wenn der Suchbegriff leer ist.
     *
     * @return void
     */
    public function testGetOptionsReturnsAllIconsWhenSearchIsEmpty(): void
    {
        // Anordnen
        $iconInfos = [
            'home'  => [
                'label'     => 'Home Icon',
                'styles'    => ['solid']
            ],
            'star'  => [
                'label'     => 'Star Icon',
                'styles'    => ['solid']
            ]
        ];

        $expected = [
            'fa-solid fa-home'  => 'fa-solid fa-home',
            'fa-solid fa-star'  => 'fa-solid fa-star'
        ];

        // Ausführen
        $rtn = $this->iconHelper->getOptions($iconInfos, 'solid', '');

        // Assert
        $this->assertEquals($expected, $rtn);
    }


    /**
     * Test: getOptions überspringt Icons, deren 'styles'-Key fehlt.
     *
     * @return void
     */
    public function testGetOptionsSkipsIconsWithMissingStylesKey(): void
    {
        // Anordnen
        $iconInfos = [
            'home' => [
                'label' => 'Home Icon'
                // 'styles' fehlt absichtlich
            ]
        ];

        // Ausführen
        $rtn = $this->iconHelper->getOptions($iconInfos, 'solid');

        // Assert
        $this->assertEquals([], $rtn);
    }


    /**
     * Test: getOptions überspringt Icons, deren Style nicht dem gesuchten entspricht.
     *
     * @return void
     */
    public function testGetOptionsSkipsIconsWithNonMatchingStyle(): void
    {
        // Anordnen
        $iconInfos = [
            'home' => [
                'label'     => 'Home Icon',
                'styles'    => ['regular']
            ]
        ];

        // Ausführen
        $rtn = $this->iconHelper->getOptions($iconInfos, 'solid');

        // Assert
        $this->assertEquals([], $rtn);
    }


    /**
     * Test: getStyles gibt leeres Array zurück, wenn $iconInfos leer ist.
     *
     * @return void
     */
    public function testGetStyleReturnEmptyArrayIfNoIconInfosFound(): void
    {
        // Anordnen
        $iconInfos = [];

        // Ausführen & Assert
        $this->assertEmpty($this->iconHelper->getStyles($iconInfos));
    }


    /**
     * Test: getStyles gibt leeres Array zurück, wenn keine Styles vorhanden sind.
     *
     * @return void
     */
    public function testGetStyleReturnEmptyArrayIfNoStylesFound(): void
    {
        // Anordnen
        $iconInfos = [
            'home' => [
                'label'     => 'Home Icon',
                'styles'    => []
            ]
        ];

        // Ausführen & Assert
        $this->assertEmpty($this->iconHelper->getStyles($iconInfos));
    }


    /**
     * Test: getStyles gibt die gefundenen Styles korrekt zurück.
     *
     * @return void
     */
    public function testGetStyleReturnStyleIfFound(): void
    {
        // Anordnen
        $expected   = ['solid', 'regular'];
        $iconInfos  = [
            'home' => [
                'label'     => 'Home Icon',
                'styles'    => ['solid', 'regular']
            ]
        ];

        // Ausführen & Assert
        $this->assertSame($expected, $this->iconHelper->getStyles($iconInfos));
    }


    /**
     * Test: getStyles dedupliziert Styles, die in mehreren Icons vorkommen.
     *
     * @return void
     */
    public function testGetStylesDeduplicatesStylesAcrossMultipleIcons(): void
    {
        // Anordnen
        $expected   = ['solid', 'regular'];
        $iconInfos  = [
            'home'  => [
                'label'     => 'Home Icon',
                'styles'    => ['solid', 'regular']
            ],
            'star'  => [
                'label'     => 'Star Icon',
                'styles'    => ['solid']
            ]
        ];

        // Ausführen
        $rtn = $this->iconHelper->getStyles($iconInfos);

        // Assert
        $this->assertSame($expected, $rtn);
    }


    /**
     * Test: getStyles überspringt nicht-string Styles und gibt nur gültige zurück.
     *
     * @return void
     */
    public function testGetStylesSkipsNonStringStyles(): void
    {
        // Anordnen
        $expected   = ['solid'];
        $iconInfos  = [
            'home' => [
                'label'     => 'Home Icon',
                'styles'    => ['solid', 42, null, true]
            ]
        ];

        // Ausführen
        $rtn = $this->iconHelper->getStyles($iconInfos);

        // Assert
        $this->assertSame($expected, $rtn);
    }


    /**
     * Test: getStyles überspringt Icons, deren 'styles'-Key fehlt oder kein Array ist.
     *
     * @return void
     */
    public function testGetStylesSkipsIconsWithMissingOrInvalidStylesKey(): void
    {
        // Anordnen
        $iconInfos = [
            'home' => [
                'label' => 'Home Icon'
                // 'styles' fehlt absichtlich
            ],
            'star' => [
                'label'     => 'Star Icon',
                'styles'    => 'solid' // kein Array
            ]
        ];

        // Ausführen
        $rtn = $this->iconHelper->getStyles($iconInfos);

        // Assert
        $this->assertSame([], $rtn);
    }
}
