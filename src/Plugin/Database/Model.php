<?php

namespace JamstackPress\Database;

use JamstackPress\Database\Builder;
use JsonSerializable;

class Model implements JsonSerializable
{
    /**
     * The model's table.
     * 
     * @var string
     */
    protected $table;

    /**
     * The model's primary key.
     * 
     * @var string
     */
    protected $primaryKey = 'ID';

    /**
     * The model attributes.
     * 
     * @var array
     */
    protected $attributes = [];

    /**
     * The current query builder.
     * 
     * @var \JamstackPress\Database\Builder
     */
    protected $query = null;

    /**
     * Create an instance of the model.
     * 
     * @param array $attributes = []
     */
    public function __construct(array $attributes = [])
    {
        $this->attributes = $attributes;
    }

    /**
     * Create a new instance of the builder.
     * 
     * @return \JamstackPress\Database\Builder
     */
    public function query()
    {
        if (!$this->query) {
            $this->query = new Builder($this);
        }

        return $this->query;
    }

    /**
     * Return the model's table.
     * 
     * @return string
     */
    public function getTableName()
    {
        global $wpdb;

        return $wpdb->prefix . $this->table;
    }

    /**
     * Create a collection of models from the given
     * builder results.
     * 
     * @param array $rows
     * @return \Illuminate\Collections\Collection
     */
    public function fromBuilder(array $rows)
    {
        return collect($rows)->map(function($row) {
            return new $this((array) $row);
        });
    }

    /**
     * Find a model by its primary key.
     * 
     * @param mixed $key
     * @return \JamstackPress\Database\Model
     */
    public static function find($key)
    {
        return (new static)->query()->where((new static)->primaryKey, $key)->get();
    }

    /**
     * Handle the calls to an attribute.
     * 
     * @param string $attribute
     * @return mixed
     */
    public function __get($attribute)
    {
        return $this->attributes[$attribute];
    }

    /**
     * Handle dynamically method calls into the model.
     * 
     * @param string $method
     * @param array $args
     * @return mixed
     */
    public function __call($method, $args)
    {
        return $this->query()->$method(...$args);
    }

    /**
     * Handle dynamically static method calls into the model.
     * 
     * @param string $method
     * @param array $args
     * @return mixed
     */
    public static function __callStatic($method, $args)
    {
        return (new static)->$method(...$args);
    }

    public function jsonSerialize()
    {
        return $this->attributes;
    }
}