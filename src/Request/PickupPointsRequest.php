<?php
/**
 * @author Serge Rodovnichenko <serge@syrnik.com>
 * @copyright Serge Rodovnichenko, 2023
 * @license Webasyst
 */

declare(strict_types=1);

namespace SergeR\Webasyst\FivepostSDK\Request;

use SergeR\Webasyst\FivepostSDK\{Client,
    Exceptions\AuthenticationKeyError,
    Exceptions\FivepostSDKException,
    Exceptions\UnexpectedResponse,
    RequestInterface,
    Response\PickupPointsResponse
};
use JsonSerializable;
use waException;
use waNet;
use waNetException;
use waNetTimeoutException;

/**
 *
 */
class PickupPointsRequest implements RequestInterface, JsonSerializable
{
    protected int $page = 0;
    protected int $page_size = 1000;

    public function __construct(int $page = 0, int $page_size = 1000)
    {
        $this->page_size = $page_size;
        $this->page = $page;
    }

    /**
     * @param Client $client
     * @return PickupPointsResponse
     * @throws AuthenticationKeyError
     * @throws FivepostSDKException
     * @throws UnexpectedResponse
     * @throws waException
     * @throws waNetException
     * @throws waNetTimeoutException
     */
    public function send(Client $client): PickupPointsResponse
    {
        $net = $client->query($this);
        return new PickupPointsResponse($net->getResponse());
    }

    public function getEndpoint(): string
    {
        return '/api/v1/pickuppoints/query';
    }

    public function getHttpMethod(): string
    {
        return waNet::METHOD_POST;
    }

    public function getData(): array
    {
        return ['pageSize' => $this->page_size, 'pageNumber' => $this->page];
    }

    public function jsonSerialize(): array
    {
        return $this->getData();
    }
}
