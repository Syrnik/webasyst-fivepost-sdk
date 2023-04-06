<?php
/**
 * @author Serge Rodovnichenko <serge@syrnik.com>
 * @copyright Serge Rodovnichenko, 2023
 * @license MIT
 */

declare(strict_types=1);

namespace SergeR\Webasyst\FivepostSDK\Request\CancelOrder;

use SergeR\Webasyst\FivepostSDK\Request\CancelOrderRequest;

/**
 *
 */
class ByOrderIdRequest extends CancelOrderRequest
{
    /**
     * @return string
     */
    public function getEndpoint(): string
    {
        return parent::getEndpoint() . "/byOrderId/$this->id";
    }
}
