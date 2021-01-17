<?php


namespace amirgonvt\Press;


class Press
{
    public static function configNotPublished(): bool
    {
        return is_null(config('press'));
    }

    public static function driver()
    {
        $driver = ucfirst(config('press.driver'));
        $class = "amirgonvt\\Press\\Drivers\\" . $driver . "Driver";

        return new $class;
    }
}