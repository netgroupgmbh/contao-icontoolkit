<?php

/**
 * @since       07.09.2024 - 16:41
 *
 * @author      Patrick Froch <info@easySolutionsIT.de>
 *
 * @see         http://easySolutionsIT.de
 *
 * @copyright   e@sy Solutions IT 2024
 * @license     EULA
 */

declare(strict_types=1);

namespace NetGroup\IconToolkit\Tests\Services\Helper;

use Contao\CoreBundle\Routing\ScopeMatcher;
use NetGroup\IconToolkit\Classes\Services\Helper\ScopeHelper;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class ScopeHelperTest extends TestCase
{


    /**
     * @var MockObject|(RequestStack&MockObject)
     */
    private $requestStack;


    /**
     * @var (ScopeMatcher&MockObject)|MockObject
     */
    private $scopeMatcher;


    /**
     * @var MockObject|(Request&MockObject)
     */
    private $request;


    /**
     * @var ScopeHelper
     */
    private ScopeHelper $scopeHelper;


    protected function setUp(): void
    {
        $this->requestStack = $this->getMockBuilder(RequestStack::class)
                                   ->disableOriginalConstructor()
                                   ->getMock();

        $this->scopeMatcher = $this->getMockBuilder(ScopeMatcher::class)
                                   ->disableOriginalConstructor()
                                   ->getMock();

        $this->request      = $this->getMockBuilder(Request::class)
                                   ->disableOriginalConstructor()
                                   ->getMock();

        $this->scopeHelper  = new ScopeHelper($this->requestStack, $this->scopeMatcher);
    }


    public function testIsBackendReturnFalseIfRequestIsNull(): void
    {
        $this->requestStack->expects($this->once())
                           ->method('getCurrentRequest')
                           ->willReturn(null);

        $this->scopeMatcher->expects($this->never())
                           ->method('isBackendRequest');

        $this->assertFalse($this->scopeHelper->isBackend());
    }


    public function testIsBackendReturnFalseIfRequestIsNotABackendRequest(): void
    {
        $this->requestStack->expects($this->once())
                           ->method('getCurrentRequest')
                           ->willReturn($this->request);

        $this->scopeMatcher->expects($this->once())
                           ->method('isBackendRequest')
                           ->with($this->request)
                           ->willReturn(false);

        $this->assertFalse($this->scopeHelper->isBackend());
    }


    public function testIsBackendReturnTrueIfRequestIsABackendRequest(): void
    {
        $this->requestStack->expects($this->once())
                           ->method('getCurrentRequest')
                           ->willReturn($this->request);

        $this->scopeMatcher->expects($this->once())
                           ->method('isBackendRequest')
                           ->with($this->request)
                           ->willReturn(true);

        $this->assertTrue($this->scopeHelper->isBackend());
    }


    public function testIsFrontendReturnFalseIfRequestIsNull(): void
    {
        $this->requestStack->expects($this->once())
                           ->method('getCurrentRequest')
                           ->willReturn(null);

        $this->scopeMatcher->expects($this->never())
                           ->method('isFrontendRequest');

        $this->assertFalse($this->scopeHelper->isFrontend());
    }


    public function testIsFrontendReturnFalseIfRequestIsNotAFrontendRequest(): void
    {
        $this->requestStack->expects($this->once())
                           ->method('getCurrentRequest')
                           ->willReturn($this->request);

        $this->scopeMatcher->expects($this->once())
                           ->method('isFrontendRequest')
                           ->with($this->request)
                           ->willReturn(false);

        $this->assertFalse($this->scopeHelper->isFrontend());
    }


    public function testIsFrontendReturnTrueIfRequestIsAFrontendRequest(): void
    {
        $this->requestStack->expects($this->once())
                           ->method('getCurrentRequest')
                           ->willReturn($this->request);

        $this->scopeMatcher->expects($this->once())
                           ->method('isFrontendRequest')
                           ->with($this->request)
                           ->willReturn(true);

        $this->assertTrue($this->scopeHelper->isFrontend());
    }
}
