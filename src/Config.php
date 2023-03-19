<?php
/**
 * @author Serge Rodovnichenko <serge@syrnik.com>
 * @copyright Serge Rodovnichenko, 2023
 * @license Webasyst
 */

declare(strict_types=1);

namespace SergeR\Webasyst\FivepostSDK;

use Closure;

/**
 *
 */
class Config
{
    /** @var string */
    const TEST_MODE = 'test';

    /** @var string */
    const PRODUCTION_MODE = 'production';

    /** @var string */
    protected string $mode = 'test';

    /** @var string */
    protected string $base_url = '';

    protected string $api_key;

    /** @var callable|Closure|null */
    protected $save_callback = null;

    protected string $bearer_token = '';

    protected int $token_lifetime = 0;

    /**
     * @param string $api_key
     * @param string $mode
     */
    public function __construct(string $api_key, string $mode = self::PRODUCTION_MODE)
    {
        $this->api_key = $api_key;
        $this->mode = $mode;
    }

    /**
     * @return string
     */
    public function getMode(): string
    {
        return $this->mode;
    }

    /**
     * @return string
     */
    public function getApiKey(): string
    {
        return $this->api_key;
    }

    public function registerSaveCallback(callable|Closure $save_callback): Config
    {
        $this->save_callback = $save_callback;
        return $this;
    }

    /**
     * @param string $mode
     * @return Config
     */
    public function setMode(string $mode): Config
    {
        $this->mode = $mode;
        return $this;
    }

    /**
     * @param string $bearer_token
     * @return Config
     */
    public function setBearerToken(string $bearer_token): Config
    {
        $this->bearer_token = $bearer_token;
        return $this;
    }

    /**
     * @return string
     */
    public function getBearerToken(): string
    {
        return $this->bearer_token;
    }

    /**
     * @param int $token_lifetime
     * @return Config
     */
    public function setTokenLifetime(int $token_lifetime): Config
    {
        $this->token_lifetime = $token_lifetime;
        return $this;
    }

    /**
     * @return int
     */
    public function getTokenLifetime(): int
    {
        return $this->token_lifetime;
    }

    /**
     * @return $this
     */
    public function saveBearerToken(): Config
    {
        if ($this->save_callback && is_callable($this->save_callback))
            call_user_func_array($this->save_callback, [$this->getBearerToken(), $this->getTokenLifetime()]);

        return $this;
    }

    public function getBaseUrl(): string
    {
        return self::PRODUCTION_MODE === $this->mode ? 'https://api-omni.x5.ru' : 'https://api-preprod-omni.x5.ru';
    }

}
