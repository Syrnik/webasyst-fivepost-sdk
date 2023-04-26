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
use SergeR\Webasyst\FivepostSDK\Response\OrderLabelsResponse;
use SergeR\Webasyst\FivepostSDK\ResponseInterface;

/**
 *
 */
abstract class OrderLabelsRequest implements \SergeR\Webasyst\FivepostSDK\RequestInterface
{
    /** @var string[] */
    protected array $ids;

    /** @var string|null null|PDF|ZIP */
    protected ?string $format = null;

    public function __construct(string ...$id)
    {
        $id = array_map('trim', $id);
        $id = array_filter($id, 'strlen');
        if (!$id) throw new \InvalidArgumentException("Требуется хотя бы один ID");
        $this->ids = $id;
    }

    /**
     * @param Client $client
     * @return ResponseInterface
     * @throws AuthenticationKeyError
     * @throws FivepostSDKException
     * @throws UnexpectedResponse
     * @throws \waException
     * @throws \waNetException
     * @throws \waNetTimeoutException
     */
    public function send(Client $client): ResponseInterface
    {
        $net = $client->query($this);
        return new OrderLabelsResponse($net->getResponseHeader(), $net->getResponse(true));
    }

    /**
     * @return string
     */
    public function getEndpoint(): string
    {
        return '/api/v1/orderLabels';
    }

    /**
     * @return string
     */
    public function getHttpMethod(): string
    {
        return 'POST';
    }

    /**
     * @param string|null $format
     * @return OrderLabelsRequest
     */
    public function setFormat(?string $format): OrderLabelsRequest
    {
        $this->format = $format;
        return $this;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        $key = $this->arrayKey();
        return [$key => $this->ids];
    }

    /**
     * @return array
     */
    public function waNetOptions(): array
    {
        return [
            'format'         => \waNet::FORMAT_RAW,
            'request_format' => \waNet::FORMAT_JSON,
            'timeout'        => 60
        ];
    }

    abstract protected function arrayKey(): string;
}
