<?php

namespace JamstackPress\Database;

use \ClanCats\Hydrahon\Builder as Hydrahon;

class Builder
{
    /**
     * The builder instance.
     * 
     * @var \ClanCats\Hydrahon\Builder
     */
    protected $hydrahon;

    /**
     * The associated model.
     * 
     * @var \JamstackPress\Database\Model
     */
    protected $model;

    /**
     * The methods of the Builder that should
     * be overriden.
     * 
     * @var array
     */
    protected $overriden = ['get'];

    /**
     * Creates an instance of the builder.
     * 
     * @return \ClanCats\Hydrahon\Builder
     */
    public function __construct($model)
    {
        $this->model = $model;

        // Create the Hydrahon instance.
        $this->hydrahon = new Hydrahon('mysql', function($query, $sql, $args) {
            global $wpdb;

            return $wpdb->get_results(
                empty($args) ? $sql : $wpdb->prepare(str_replace('?', '%s', $sql), ...$args)
            );
        });

        $this->hydrahon = $this->hydrahon->select()->table($model->getTableName());
    }

    /**
     * Return the results of the current builder.
     * 
     * @return \Illuminate\Collections\Collection
     */
    public function get()
    {
        return $this->model->fromBuilder($this->hydrahon->get());
    }

    /**
     * Handle dynamically called methods into the model.
     * 
     * @param string $method
     * @param array $args
     * @return mixed
     */
    public function __call($method, $args)
    {
        if (!in_array($method, $this->overriden)) {
            $this->hydrahon->$method(...$args);
            
            return $this->model;
        }

        return $this->$method(...$args);
    }
}