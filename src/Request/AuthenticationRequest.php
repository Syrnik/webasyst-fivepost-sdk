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
    Response\AuthenticationResponse
};

/**
 *
 */
class AuthenticationRequest implements RequestInterface
{
    /** @var string */
    protected string $api_key;

    public function __construct(string $api_key)
    {
        $this->api_key = $api_key;
    }

    public function getEndpoint(): string
    {
        return "/jwt-generate-claims/rs256/1?apikey={$this->api_key}";
    }

    public function getHttpMethod(): string
    {
        return 'POST';
    }

    public function getData(): ?array
    {
        return ['subject' => 'OpenAPI', 'audience' => 'A122019!'];
    }

    /**
     * @param Client $client
     * @return AuthenticationResponse
     * @throws UnexpectedResponse
     * @throws AuthenticationKeyError
     * @throws FivepostSDKException
     * @throws \waException
     * @throws \waNetException
     * @throws \waNetTimeoutException
     */
    public function send(Client $client): AuthenticationResponse
    {
        return new AuthenticationResponse($client->query($this));
    }
}
