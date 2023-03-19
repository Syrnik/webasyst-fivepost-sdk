<?php
/**
 * @author Serge Rodovnichenko <serge@syrnik.com>
 * @copyright Serge Rodovnichenko, 2023
 * @license
 */

declare(strict_types=1);

namespace SergeR\Webasyst\FivepostSDK\Exceptions;

/**
 *
 */
class AuthenticationKeyError extends FivepostSDKException
{
    protected string $fault_string = '';

    protected string $error_code = '';

    public function __construct($message = 'Ошибка ключа API', $code = 401, $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public static function fromResponse(mixed $response): AuthenticationKeyError
    {
        $ex = new self();
        if (is_array($response)) {
            $ex->fault_string = $response['fault']['faultstring'] ?? '';
            $ex->error_code = $response['fault']['detail']['errorcode'] ?? '';
        }

        return $ex;
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

    /**
     * @param string $fault_string
     * @return AuthenticationKeyError
     */
    public function setFaultString(string $fault_string): AuthenticationKeyError
    {
        $this->fault_string = $fault_string;
        return $this;
    }

    /**
     * @param string $error_code
     * @return AuthenticationKeyError
     */
    public function setErrorCode(string $error_code): AuthenticationKeyError
    {
        $this->error_code = $error_code;
        return $this;
    }
}
