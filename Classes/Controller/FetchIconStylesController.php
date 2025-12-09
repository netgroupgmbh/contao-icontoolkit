<?php

/**
 * @since       08.12.2025 - 07:44
 *
 * @author      Patrick Froch <info@netgroup.de>
 *
 * @see         http://www.netgroup.de
 *
 * @copyright   NetGroup GmbH 2025
 */

declare(strict_types=1);

namespace NetGroup\IconToolkit\Classes\Controller;

use Contao\CoreBundle\Controller\AbstractBackendController;
use Doctrine\DBAL\Exception;
use NetGroup\IconToolkit\Classes\Services\Helper\IconHelper;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('%contao.backend.route_prefix%/ng-fetch-icon-styles', name: self::class, defaults: ['_scope' => 'backend'])]
class FetchIconStylesController extends AbstractBackendController
{


    /**
     * @param IconHelper $icoHelper
     */
    public function __construct(private readonly IconHelper $icoHelper)
    {
    }


    /**
     * Gibt die gefundenene Styles zurück.
     *
     * @return Response
     *
     * @throws Exception
     * @throws \JsonException
     */
    public function __invoke(): Response
    {
        $data       = $this->icoHelper->parseIconList();
        $options    = $this->icoHelper->getStyles($data);

        return $this->json($options);
    }
}
