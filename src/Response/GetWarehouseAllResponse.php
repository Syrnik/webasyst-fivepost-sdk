<?php
/**
 * @author Serge Rodovnichenko <serge@syrnik.com>
 * @copyright Serge Rodovnichenko, 2023
 * @license MIT
 */

declare(strict_types=1);

namespace SergeR\Webasyst\FivepostSDK\Response;

class GetWarehouseAllResponse implements \SergeR\Webasyst\FivepostSDK\ResponseInterface, \Countable
{
    public function __construct(protected array $data)
    {
    }

    public function count(): int
    {
        return count($this->data['content'] ?? []);
    }
    public function isEmpty(): bool
    {
        return boolval($this->data['empty'] ?? true);
    }

    public function size(): int
    {
        return intval($this->data['size'] ?? 0);
    }

    public function totalElements(): int
    {
        return intval($this->data['totalElements'] ?? 0);
    }

    public function totalPages(): int
    {
        return intval($this->data['totalPages'] ?? 0);
    }

    public function isLast(): bool
    {
        return boolval($this->data['last'] ?? true);
    }

    public function isFirst(): bool
    {
        return boolval($this->data['first'] ?? true);
    }

    public function pageNumber(): int
    {
        return intval($this->data['number'] ?? 0);
    }

    public function getContent(): array
    {
        return (array)($this->data['content'] ?? []);
    }
}
