<?php
/**
 * @author Serge Rodovnichenko <serge@syrnik.com>
 * @copyright Serge Rodovnichenko, 2023
 * @license MIT
 */

declare(strict_types=1);

namespace SergeR\Webasyst\FivepostSDK\Request\OrderLabels;

/**
 *
 */
class ByOrderIdRequest extends \SergeR\Webasyst\FivepostSDK\Request\OrderLabelsRequest
{
    public function getEndpoint(): string
    {
        return parent::getEndpoint() . '/byOrderId' . ($this->format ? '?format=' . strtoupper($this->format) : '');
    }

    /**
     * @return string
     */
    protected function arrayKey(): string
    {
        return 'orderIds';
    }
}
