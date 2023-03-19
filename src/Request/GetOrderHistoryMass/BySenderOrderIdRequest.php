<?php
/**
 * @author Serge Rodovnichenko <serge@syrnik.com>
 * @copyright Serge Rodovnichenko, 2023
 * @license Webasyst
 */

declare(strict_types=1);

namespace SergeR\Webasyst\FivepostSDK\Request\GetOrderHistoryMass;

use SergeR\Webasyst\FivepostSDK\Request\GetOrderHistoryMassRequest;

class BySenderOrderIdRequest extends GetOrderHistoryMassRequest
{
    public function getEndpoint(): string
    {
        return parent::getEndpoint() . '/bySenderOrderId';
    }

    public function getData(): ?array
    {
        return parent::getData() + ['senderOrderIdList' => $this->orders];
    }
}
