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

class FetchIconListController extends AbstractBackendController
{


    /**
     * @param IconHelper $icoHelper
     */
    public function __construct(private readonly IconHelper $icoHelper)
    {
    }


    /**
     * Gibt die Liste der Icons zurück.
     *
     * @param string $style
     * @param string $search
     *
     * @return Response
     *
     * @throws Exception
     * @throws \JsonException
     */
    public function __invoke(string $style = 'solid', string $search = ''): Response
    {
        $data       = $this->icoHelper->parseIconList();
        $options    = $this->icoHelper->getOptions($data, $style, $search);

        return $this->json($options);
    }
}
