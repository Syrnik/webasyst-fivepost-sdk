<?php
/**
 * @author Serge Rodovnichenko <serge@syrnik.com>
 * @copyright Serge Rodovnichenko, 2023
 * @license Webasyst
 */

declare(strict_types=1);

namespace SergeR\Webasyst\FivepostSDK;

/**
 *
 */
interface RequestInterface
{
    public function send(Client $client): ResponseInterface;

    public function getEndpoint(): string;

    public function getHttpMethod(): string;

    public function getData(): ?array;

}
