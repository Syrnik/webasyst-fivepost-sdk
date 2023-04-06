<?php
/**
 * @author Serge Rodovnichenko <serge@syrnik.com>
 * @copyright Serge Rodovnichenko, 2023
 * @license MIT
 */

declare(strict_types=1);

namespace SergeR\Webasyst\FivepostSDK\Response;

/**
 *
 */
class CancelOrderResponse implements \SergeR\Webasyst\FivepostSDK\ResponseInterface
{
    public function __construct(protected array $data)
    {
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }
}
