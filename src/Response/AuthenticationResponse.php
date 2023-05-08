<?php
/**
 * @author Serge Rodovnichenko <serge@syrnik.com>
 * @copyright Serge Rodovnichenko, 2023
 * @license Webasyst
 */

declare(strict_types=1);

namespace SergeR\Webasyst\FivepostSDK\Response;

use SergeR\Webasyst\FivepostSDK\{Exceptions\UnexpectedResponse, ResponseInterface};
use waException;
use waNet;
use waUtils;

/**
 *
 */
class AuthenticationResponse implements ResponseInterface
{
    /**
     * @var string|mixed
     */
    protected string $token = '';

    /**
     * @var string|mixed
     */
    protected string $fault_string = '';

    /**
     * @var string|mixed
     */
    protected string $error_code = '';

    /**
     * @param waNet $net
     * @throws UnexpectedResponse
     */
    public function __construct(waNet $net)
    {
        $result = $net->getResponse();

        $http_code = $net->getResponseHeader('http_code');
        $response_content_type = $net->getResponseHeader('Content-Type');

        if ('application/json' === $response_content_type) try {
            $result = waUtils::jsonDecode($result, true);
        } catch (waException $e) {
            throw new UnexpectedResponse("Ошибка декодирования json", 200, $e);
        }

        if (401 === $http_code) {
            if ('text/plain' === $response_content_type)
                $this->fault_string = $result;
            elseif ('application/json' === $response_content_type) {
                if (is_array($result) && ($result['fault'] ?? '')) {
                    $this->fault_string = $result['fault']['faultstring'];
                    $this->error_code = $result['fault']['detail']['errorcode'];
                    return;
                }
            }
        }

        if (!is_array($result) || 'ok' !== ($result['status'] ?? '') || !($token = ($result['jwt'] ?? '')))
            throw (new UnexpectedResponse('Unexpected response', $net->getResponseHeader('http_code')))->setResponse($result);

        $this->token = $token;
    }

    /**
     * @return bool
     */
    public function isError(): bool
    {
        return !$this->token || $this->fault_string || $this->error_code;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @return string
     */
    public function getFaultString(): string
    {
        return $this->fault_string;
    }

    /**
     * @return string
     */
    public function getErrorCode(): string
    {
        return $this->error_code;
    }
}
