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

/**
 *
 */
class GetWarehouseAllRequest implements RequestInterface
{
    /** @var int */
    protected int $page = 0;

    /**
     * @param int $page
     */
    public function __construct(int $page = 0)
    {
        $this->page = $page;
    }

    /**
     * @param int $page
     * @return GetWarehouseAllRequest
     */
    public function setPage(int $page): self
    {
        $this->page = $page;
        return $this;
    }

    /**
     * @param Client $client
     * @return GetWarehouseAllResponse
     * @throws \SergeR\Webasyst\FivepostSDK\Exceptions\AuthenticationKeyError
     * @throws \SergeR\Webasyst\FivepostSDK\Exceptions\FivepostSDKException
     * @throws \SergeR\Webasyst\FivepostSDK\Exceptions\UnexpectedResponse
     * @throws \waException
     * @throws \waNetException
     * @throws \waNetTimeoutException
     */
    public function send(Client $client): GetWarehouseAllResponse
    {
        $net = $client->query($this);
        return new GetWarehouseAllResponse($net->getResponse());
    }

    /**
     * @return string
     */
    public function getEndpoint(): string
    {
        return '/api/v1/getWarehouseAll';
    }

    /**
     * @return string
     */
    public function getHttpMethod(): string
    {
        return 'GET';
    }

    /**
     * @return int[]|null
     */
    public function getData(): ?array
    {
        return ['page' => $this->page];
    }
}
