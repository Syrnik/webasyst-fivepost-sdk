<?php
/**
 * @author Serge Rodovnichenko <serge@syrnik.com>
 * @copyright Serge Rodovnichenko, 2023
 * @license MIT
 */

declare(strict_types=1);

namespace SergeR\Webasyst\FivepostSDK\Request\CancelOrder;

/**
 *
 */
class BySenderOrderIdRequest extends \SergeR\Webasyst\FivepostSDK\Request\CancelOrderRequest
{
    /**
     * @return string
     */
    public function getEndpoint(): string
    {
        return parent::getEndpoint() . "/bySenderOrderId/$this->id";
    }
}
