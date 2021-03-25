<?php

namespace JamstackPress\Core;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

/**
 * @since 0.0.1
 */
abstract class QueryFilter 
{

    /**
     * The current request.
     * 
     * @var \WP_REST_Request $request
     */
    protected $request;

    /**
     * The builder instance.
     * 
     * @var \Illuminate\Database\Eloquent\Builder
     */
    protected $builder;

    /**
     * Create a new instance of the class.
     * 
     * @param \WP_REST_Request $request
     * @return void
     */
    public function __construct(\WP_REST_Request $request)
    {
        $this->request = $request;
    }

    /**
     * Apply the filters to the builder.
     * 
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    public function apply(Builder $builder)
    {
        $this->builder = $builder;

        // Apply each of the filters specified.
        foreach ($this->request->get_params() as $name => $value)
        {
            // If the filter doesn't exist, continue.
            if (!method_exists($this, $name)) {
                continue;
            }

            $method = Str::camel($name);

            /* If there's a value, pass it as argument. Otherwise
             * call the method without arguments. For example,
             * for an &embed query */
            if (strlen($value)) {
                $this->$name($value);
            } else {
                $this->$name();
            }
        }
    }
}