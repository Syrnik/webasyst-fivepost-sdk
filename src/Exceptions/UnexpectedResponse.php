<?php
/**
 * @author Serge Rodovnichenko <serge@syrnik.com>
 * @copyright Serge Rodovnichenko, 2023
 * @license
 */

declare(strict_types=1);

namespace SergeR\Webasyst\FivepostSDK\Exceptions;

class UnexpectedResponse extends FivepostSDKException
{
    /** @var mixed */
    protected $response = null;

    public function __construct(string $message = 'Unexpected response', $code = 200, $previous = null)
    {
        parent::__construct($message, intval($code), $previous);
    }

    /**
     * @param mixed $response
     * @return UnexpectedResponse
     */
    public function setResponse($response): UnexpectedResponse
    {
        $this->response = $response;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }
}
