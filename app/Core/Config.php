<?php

namespace App\Core;

class Config
{
    /** @var array<string, mixed> */
    private static array $values = [];

    /**
     * Load configuration from the config file.
     */
    public static function load(string $configPath): void
    {
        if (!file_exists($configPath)) {
            throw new \RuntimeException('Config file not found: ' . $configPath);
        }

        $data = require $configPath;

        if (is_array($data)) {
            self::$values = array_merge(self::$values, $data);
        }
    }

    /**
     * Get a configuration value by key.
     *
     * @param mixed $default
     * @return mixed
     */
    public static function get(string $key, $default = null)
    {
        return self::$values[$key] ?? $default;
    }

    /**
     * Set a configuration value at runtime.
     *
     * @param mixed $value
     */
    public static function set(string $key, $value): void
    {
        self::$values[$key] = $value;
    }
}
