<?php
/**
 * @author Serge Rodovnichenko <serge@syrnik.com>
 * @copyright Serge Rodovnichenko, 2023
 * @license MIT
 */

declare(strict_types=1);

namespace SergeR\Webasyst\FivepostSDK\Request;

use SergeR\Webasyst\FivepostSDK\Client;
use SergeR\Webasyst\FivepostSDK\Exceptions\AuthenticationKeyError;
use SergeR\Webasyst\FivepostSDK\Exceptions\FivepostSDKException;
use SergeR\Webasyst\FivepostSDK\Exceptions\UnexpectedResponse;
use SergeR\Webasyst\FivepostSDK\RequestInterface;
use SergeR\Webasyst\FivepostSDK\Response\CancelOrderResponse;

/**
 *
 */
abstract class CancelOrderRequest implements RequestInterface
{
    protected string $id;

    /**
     * @param string $id
     */
    public function __construct(string $id)
    {
        $this->id = $id;
    }

    /**
     * @throws \waNetException
     * @throws AuthenticationKeyError
     * @throws \waException
     * @throws UnexpectedResponse
     * @throws \waNetTimeoutException
     * @throws FivepostSDKException
     */
    public function send(Client $client): CancelOrderResponse
    {
        $net = $client->query($this);
        return new CancelOrderResponse($net->getResponse());
    }

    public function getEndpoint(): string
    {
        return '/api/v2/cancelOrder';
    }

    public function getHttpMethod(): string
    {
        return 'DELETE';
    }

    public function getData(): ?array
    {
        return null;
    }
}
