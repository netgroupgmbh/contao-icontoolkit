<?php

/**
 * @since       28.11.2025 - 08:01
 *
 * @author      Patrick Froch <info@netgroup.de>
 *
 * @see         http://www.netgroup.de
 *
 * @copyright   NetGroup GmbH 2025
 */

declare(strict_types=1);

namespace NetGroup\IconToolkit\Tests\Services\Factories;

use NetGroup\IconToolkit\Classes\Services\Factories\FinderFactory;
use PHPUnit\Framework\TestCase;

class FinderFactoryTest extends TestCase
{

    /**
     * @var FinderFactory
     */
    private FinderFactory $factory;


    protected function setUp(): void
    {
        $this->factory = new FinderFactory();
    }


    public function testCreateFinder(): void
    {
        $this->assertNotNull($this->factory->createFinder());
    }


    public function testCreateFileSystem(): void
    {
        $this->assertNotNull($this->factory->createFileSystem());
    }
}
