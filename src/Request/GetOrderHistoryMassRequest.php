<?php
/**
 * @author Serge Rodovnichenko <serge@syrnik.com>
 * @copyright Serge Rodovnichenko, 2023
 * @license Webasyst
 */

declare(strict_types=1);

namespace SergeR\Webasyst\FivepostSDK\Request;

use JsonSerializable;
use SergeR\Webasyst\FivepostSDK\Client;
use SergeR\Webasyst\FivepostSDK\Exceptions\AuthenticationKeyError;
use SergeR\Webasyst\FivepostSDK\Exceptions\FivepostSDKException;
use SergeR\Webasyst\FivepostSDK\Exceptions\UnexpectedResponse;
use SergeR\Webasyst\FivepostSDK\RequestInterface;
use SergeR\Webasyst\FivepostSDK\Response\GetOrderHistoryMassResponse;
use waException;
use waNetException;
use waNetTimeoutException;

/**
 * todo implement datetime interval support
 */
abstract class GetOrderHistoryMassRequest implements RequestInterface, JsonSerializable
{
    protected array $orders;

    public function __construct(string ...$orders)
    {
        $this->orders = $orders;
    }

    /**
     * @throws waNetException
     * @throws AuthenticationKeyError
     * @throws waException
     * @throws UnexpectedResponse
     * @throws waNetTimeoutException
     * @throws FivepostSDKException
     */
    public function send(Client $client): GetOrderHistoryMassResponse
    {
        $net = $client->query($this);
        return new GetOrderHistoryMassResponse($net->getResponse());
    }

    public function getEndpoint(): string
    {
        return '/api/v1/getOrderHistoryMass';
    }

    public function getHttpMethod(): string
    {
        return 'POST';
    }

    public function getData(): ?array
    {
        return [];
    }

    public function jsonSerialize()
    {
        return $this->getData();
    }
}
