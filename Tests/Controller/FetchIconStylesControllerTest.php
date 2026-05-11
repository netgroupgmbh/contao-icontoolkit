<?php

/**
 * @since       09.12.2025 - 14:46
 *
 * @author      Patrick Froch <info@netgroup.de>
 *
 * @see         http://www.netgroup.de
 *
 * @copyright   NetGroup GmbH 2025
 */

declare(strict_types=1);

namespace NetGroup\IconToolkit\Tests\Controller;

use NetGroup\IconToolkit\Classes\Controller\FetchIconStylesController;
use NetGroup\IconToolkit\Classes\Services\Helper\IconHelper;
use PHPUnit\Framework\Attributes\AllowMockObjectsWithoutExpectations;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;

#[AllowMockObjectsWithoutExpectations]
class FetchIconStylesControllerTest extends TestCase
{

    /**
     * @var (IconHelper&MockObject)|MockObject
     */
    private $icoHelper;


    /**
     * @var MockObject|(JsonResponse&MockObject)
     */
    private $json;


    /**
     * @var FetchIconStylesController
     */
    private FetchIconStylesController $controller;


    protected function setUp(): void
    {
        $this->icoHelper        = $this->getMockBuilder(IconHelper::class)
                                       ->disableOriginalConstructor()
                                       ->getMock();

        $this->json             = $this->getMockBuilder(JsonResponse::class)
                                       ->disableOriginalConstructor()
                                       ->getMock();

        $this->controller       = $this->getMockBuilder(FetchIconStylesController::class)
                                       ->setConstructorArgs([$this->icoHelper])
                                       ->onlyMethods(['json'])
                                       ->getMock();
    }


    /**
     * @return void
     *
     * @throws \Doctrine\DBAL\Exception
     * @throws \JsonException
     */
    public function testInvoke(): void
    {
        $data       = ['data'];
        $options    = ['options'];

        $this->icoHelper->expects($this->once())
                        ->method('parseIconList')
                        ->willReturn($data);

        $this->icoHelper->expects($this->once())
                        ->method('getStyles')
                        ->with($data)
                        ->willReturn($options);

        $this->controller->expects($this->once())
                         ->method('json')
                         ->with($options)
                         ->willReturn($this->json);

        $this->assertSame($this->json, $this->controller->__invoke());
    }
}
