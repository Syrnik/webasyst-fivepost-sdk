<?php
/**
 * @author Serge Rodovnichenko <serge@syrnik.com>
 * @copyright Serge Rodovnichenko, 2023
 * @license
 */

declare(strict_types=1);

namespace SergeR\Webasyst\FivepostSDK\Request;

use SergeR\Webasyst\FivepostSDK\{Client, RequestInterface, Response\OrdersResponse};

/**
 *
 */
class OrdersRequest implements RequestInterface, \JsonSerializable
{
    /**
     * @var array
     */
    protected array $orders = [];

    /**
     * @param array $orders
     */
    public function __construct(array $orders = [])
    {
        if ($orders) $this->orders = $orders;
    }


    /**
     * @param array $order
     * @return $this
     */
    public function addOrder(array $order): self
    {
        $this->orders[] = $order;
        return $this;
    }

    /**
     * @param Client $client
     * @return OrdersResponse
     * @throws \SergeR\Webasyst\FivepostSDK\Exceptions\AuthenticationKeyError
     * @throws \SergeR\Webasyst\FivepostSDK\Exceptions\FivepostSDKException
     * @throws \SergeR\Webasyst\FivepostSDK\Exceptions\UnexpectedResponse
     * @throws \waException
     * @throws \waNetException
     * @throws \waNetTimeoutException
     */
    public function send(Client $client): OrdersResponse
    {
        $net = $client->query($this);
        return new OrdersResponse($net->getResponse());
    }

    /**
     * @return string
     */
    public function getEndpoint(): string
    {
        return '/api/v3/orders';
    }

    /**
     * @return string
     */
    public function getHttpMethod(): string
    {
        return 'POST';
    }

    /**
     * @return array[]
     */
    public function getData(): array
    {
        return ['partnerOrders' => $this->orders];
    }

    /**
     * @return array[]
     */
    public function jsonSerialize(): array
    {
        return $this->getData();
    }
}
