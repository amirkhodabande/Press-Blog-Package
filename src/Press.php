<?php


namespace amirgonvt\Press;


class Press
{
    public static function configNotPublished()
    {
        return is_null(config('press'));
    }
}