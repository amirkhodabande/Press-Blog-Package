<?php


namespace amirgonvt\Press;


class Press
{
    public function configNotPublished(): bool
    {
        return is_null(config('press'));
    }

    /**
     * Get an instance of the set driver
     * 
     * @return mixed
     */
    public function driver()
    {
        $driver = ucfirst(config('press.driver'));
        $class = "amirgonvt\\Press\\Drivers\\" . $driver . "Driver";

        return new $class;
    }

    public function path()
    {
        return config('press.path', 'blogs');
    }
}