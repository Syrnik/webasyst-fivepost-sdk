<?php
/**
 * @author Serge Rodovnichenko <serge@syrnik.com>
 * @copyright Serge Rodovnichenko, 2023
 * @license
 */

declare(strict_types=1);

namespace SergeR\Webasyst\FivepostSDK\Request;

use SergeR\Webasyst\FivepostSDK\{Client, RequestInterface, Response\OrdersResponse};

class OrdersRequest implements RequestInterface, \JsonSerializable
{
    protected array $orders = [];

    /**
     * @param array $orders
     */
    public function __construct(array $orders = [])
    {
        if ($orders) $this->orders = $orders;
    }


    public function addOrder(array $order): static
    {
        $this->orders[] = $order;
        return $this;
    }

    public function send(Client $client): OrdersResponse
    {
        $net = $client->query($this);
        return new OrdersResponse($net->getResponse());
    }

    public function getEndpoint(): string
    {
        return '/api/v3/orders';
    }

    public function getHttpMethod(): string
    {
        return 'POST';
    }

    public function getData(): array
    {
        return ['partnerOrders' => $this->orders];
    }

    public function jsonSerialize(): array
    {
        return $this->getData();
    }
}
