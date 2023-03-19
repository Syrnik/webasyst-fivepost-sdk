<?php
/**
 * @author Serge Rodovnichenko <serge@syrnik.com>
 * @copyright Serge Rodovnichenko, 2023
 * @license Webasyst
 */

declare(strict_types=1);

namespace SergeR\Webasyst\FivepostSDK;

use SergeR\Webasyst\FivepostSDK\Exceptions\AuthenticationKeyError;
use SergeR\Webasyst\FivepostSDK\Exceptions\FivepostSDKException;
use SergeR\Webasyst\FivepostSDK\Exceptions\UnexpectedResponse;
use SergeR\Webasyst\FivepostSDK\Request\AuthenticationRequest;
use waException;
use waNet;
use waNetException;
use waNetTimeoutException;

/**
 *
 */
class Client
{
    /** @var Config */
    protected Config $config;

    /**
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * @param RequestInterface $request
     * @param bool $refresh_token
     * @return waNet
     * @throws AuthenticationKeyError
     * @throws Exceptions\UnexpectedResponse
     * @throws FivepostSDKException
     * @throws waNetTimeoutException
     * @throws waNetException
     * @throws waException
     */
    public function query(RequestInterface $request, bool $refresh_token = true): waNet
    {
        $options = [
            'format'             => waNet::FORMAT_JSON,
            'expected_http_code' => [200, 401],
        ];
        $custom_headers = [];

        if (!($request instanceof AuthenticationRequest)) {
            if (!$this->getConfig()->getBearerToken()) $this->_authenticate();
            $options += ['authorization' => true, 'auth_type' => 'Bearer', 'auth_key' => $this->getConfig()->getBearerToken()];
        } else {
            $options['format']=\waNet::FORMAT_RAW;
        }

        $net = new waNet($options, $custom_headers);
        $url = $this->config->getBaseUrl() . $request->getEndpoint();
        $content = $request->getData();
        $http_method = $request->getHttpMethod();

        $net->query($url, $content, $http_method);

        //$this->logRequestAndResponse($http_method, $url, $content, $net);

        $http_code = $net->getResponseHeader('http_code');

        if (401 === $http_code) {
            if (!$refresh_token)
                throw new FivepostSDKException('Authentication Failed', 401);

            if ($request instanceof AuthenticationRequest)
                throw new FivepostSDKException('Authentication Failed', 401);

            $this->_authenticate();
            return $this->query($request, false);
        }

        return $net;
    }

    /**
     * @return Config
     */
    public function getConfig(): Config
    {
        return $this->config;
    }

    /**
     * @return void
     * @throws AuthenticationKeyError
     * @throws UnexpectedResponse
     * @throws FivepostSDKException
     * @throws waException
     * @throws waNetException
     * @throws waNetTimeoutException
     */
    protected function _authenticate(): void
    {
        $response = (new AuthenticationRequest($this->config->getApiKey()))->send($this);
        if ($response->isError())
            throw (new AuthenticationKeyError)
                ->setFaultString($response->getFaultString())
                ->setErrorCode($response->getErrorCode());

        $this->config->setBearerToken($response->getToken())
            ->setTokenLifetime(3000)
            ->saveBearerToken();
    }
}
