<?php
/**
 * @author Serge Rodovnichenko <serge@syrnik.com>
 * @copyright Serge Rodovnichenko, 2023
 * @license MIT
 */

declare(strict_types=1);

namespace SergeR\Webasyst\FivepostSDK\Response;

class OrderLabelsResponse implements \SergeR\Webasyst\FivepostSDK\ResponseInterface
{
    protected string $format = '';

    protected string $filename = '';

    protected mixed $data = '';

    public function __construct(array $headers, mixed $data)
    {
        $this->data = $data;
        foreach ($headers as $key => $value) {
            if(!is_string($key)) continue;
            if ('CONTENT-TYPE' === strtoupper($key))
                $this->format = $this->parseContentType($value);
            elseif ('CONTENT-DISPOSITION' === strtoupper($key))
                $this->filename = $this->parseFilename($value);
        }
    }

    protected function parseContentType(string $header): string
    {
        [$header] = explode(';', $header);
        $header = strtolower(trim($header));
        return match ($header) {
            'application/pdf' => 'PDF',
            'application/zip' => 'ZIP',
            default => $header
        };
    }

    protected function parseFilename(string $header): string
    {
        [$type, $payload] = explode(';', $header . ';', 2);
        $matches = [];
        if ('ATTACHMENT' === strtoupper(trim($type)) && preg_match('/^filename=\"(\S+)\"$/ui', trim($payload, "\ \t\n\r\0\x0B;"), $matches)) {
            return trim($matches[1] ?? '');
        }
        return '';
    }

    /**
     * @return string
     */
    public function getFormat(): string
    {
        return $this->format;
    }

    /**
     * @return string
     */
    public function getFilename(): string
    {
        return $this->filename;
    }

    /**
     * @return mixed
     */
    public function getData(): mixed
    {
        return $this->data;
    }
}
