<?php
/**
 * @author Serge Rodovnichenko <serge@syrnik.com>
 * @copyright Serge Rodovnichenko, 2023
 * @license Webasyst
 */

declare(strict_types=1);

namespace SergeR\Webasyst\FivepostSDK\Response;

use Countable;
use SergeR\Webasyst\FivepostSDK\ResponseInterface;

/**
 * todo add ArrayAccess, find ability e t.c.
 */
class GetOrderHistoryMassResponse implements ResponseInterface, Countable
{
    public function __construct(protected array $data)
    {
    }

    public function count(): int
    {
        return count($this->data);
    }

    public function getData(): array
    {
        return $this->data;
    }
}
