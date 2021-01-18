<?php


namespace amirgonvt\Press;


class Press
{
    protected $fields = [];

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

    /**
     * Set value of the protected array $fields
     *
     * @param array $fields
     */
    public function fields(array $fields)
    {
        $this->fields = array_merge($this->fields, $fields);
    }

    public function availableFields()
    {
        return $this->fields;
    }
}