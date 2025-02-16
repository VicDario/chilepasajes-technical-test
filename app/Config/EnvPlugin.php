<?php

namespace App\Config;

class EnvPlugin
{
    public function get(string $key, $default = null)
    {
        $value = env($key);

        if ($value === null) return $default;

        if (is_string($value) && str_starts_with($value, '[') && str_ends_with($value, ']'))
            return json_decode($value, true);

        return $value;
    }
}
