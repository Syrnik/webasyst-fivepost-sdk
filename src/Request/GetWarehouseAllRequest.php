<?php
/**
 * @author Serge Rodovnichenko <serge@syrnik.com>
 * @copyright Serge Rodovnichenko, 2023
 * @license MIT
 */

declare(strict_types=1);

namespace SergeR\Webasyst\FivepostSDK\Request;

use SergeR\Webasyst\FivepostSDK\Client;
use SergeR\Webasyst\FivepostSDK\RequestInterface;
use SergeR\Webasyst\FivepostSDK\Response\GetWarehouseAllResponse;
use SergeR\Webasyst\FivepostSDK\ResponseInterface;

class GetWarehouseAllRequest implements RequestInterface
{
    public function __construct(protected int $page = 0)
    {
    }

    /**
     * @param int $page
     * @return GetWarehouseAllRequest
     */
    public function setPage(int $page): static
    {
        $this->page = $page;
        return $this;
    }

    public function send(Client $client): GetWarehouseAllResponse
    {
        $net = $client->query($this);
        return new GetWarehouseAllResponse($net->getResponse());
    }

    public function getEndpoint(): string
    {
        return '/api/v1/getWarehouseAll';
    }

    public function getHttpMethod(): string
    {
        return 'GET';
    }

    public function getData(): ?array
    {
        return ['page' => $this->page];
    }
}
