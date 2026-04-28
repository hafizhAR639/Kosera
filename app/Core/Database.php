<?php

namespace App\Core;

class Database
{
    private static ?\mysqli $instance = null;

    /**
     * Get the shared database connection (singleton).
     */
    public static function connection(): \mysqli
    {
        if (self::$instance === null || !self::$instance->ping()) {
            self::$instance = new \mysqli(
                Config::get('db_host'),
                Config::get('db_user'),
                Config::get('db_pass'),
                Config::get('db_name')
            );

            if (self::$instance->connect_error) {
                throw new \RuntimeException('Database connection failed: ' . self::$instance->connect_error);
            }

            self::$instance->set_charset('utf8mb4');
        }

        return self::$instance;
    }

    /**
     * Close the shared connection (optional, PHP closes on shutdown).
     */
    public static function close(): void
    {
        if (self::$instance !== null) {
            self::$instance->close();
            self::$instance = null;
        }
    }
}
