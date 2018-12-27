<?php

namespace YoweliKachala\PackageGenerator\Helpers;

/**
 * Class SetupHelper
 * @package YoweliKachala\PackageGenerator\Helpers
 */
class SetupHelper
{
    public static function setupEnvFile()
    {
        if (!file_exists(database_path() . '/database.sqlite')) {
            exec('touch ' . database_path() . '/database.sqlite');
        }

        if (file_exists(base_path() . '/' . '.env') && !file_exists(base_path() . '/' . '.env-bkp')) {
            exec('mv ' . base_path() . '/' . '.env ' . base_path() . '/.env-bkp');
        }

        if (!file_exists(base_path() . '/' . '.env')) {
            exec('cp ' . base_path() . '/.env.example ' . base_path() . '/.env');
        }

        if (strpos(file_get_contents(base_path() . '/' . '.env'), 'DB_DATABASE=homestead') !== false) {
            $str = file_get_contents(base_path() . '/' . '.env');
            $str = str_replace("DB_DATABASE=homestead", "DB_DATABASE=" . database_path() . "/database.sqlite", $str);
            $str = str_replace("DB_CONNECTION=mysql", "DB_CONNECTION=sqlite", $str);
            file_put_contents(base_path() . '/' . '.env', $str);
        }
    }
}