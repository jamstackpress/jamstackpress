<?php

namespace JamstackPress\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use ReflectionMethod;
use WP_REST_Request;
use Illuminate\Support\Str;

abstract class Filter
{
    /**
     * The builder instance.
     * 
     * @var \Illuminate\Database\Eloquent\Builder
     */
    protected $builder;

    /**
     * The request.
     * 
     * @var \WP_REST_Request
     */
    protected $request;

    /**
     * Create the filter instance.
     * 
     * @param \WP_REST_Request $request
     */
    public function __construct(\WP_REST_Request $request)
    {
        $this->request = $request;
    }

    /**
     * Apply the defined filters.
     * 
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return mixed
     */
    public function apply(Builder $builder)
    {
        $this->builder = $builder;
        $parameters = $this->request->get_params();

        // Apply the filters specified for each parameter.
        foreach ($parameters as $parameter => $value) {
            $method = Str::camel($parameter);

            // If the filter is not defined, continue looping.
            if (!method_exists($this, $method)) {
                continue;
            }

            // We're going to handle the fields method afterwards.
            if ($method === 'fields') {
                $fields = explode(',', $value);
                continue;
            }

            /* Check if the method needs parameters and if we received
             * a value for that method. If no value was received, continue
             * with the loop, else call the method without parameters. */
            $property = new ReflectionMethod($this, $method);
            if (count($property->getParameters()) > 0) {
                if (strlen($value)) {
                    $this->$method($value);
                } else {
                    continue;
                }
            } else {
                $this->$method();
            }
        }   

        // Get the rows.
        $rows = $this->builder->get();

        // Filter the fields.
        if (isset($fields)) {
            $rows = $this->fields($rows, $fields);
        }

        // Check if we need to paginate the results.
        if (in_array('page', array_keys($parameters))) {
            $sliced = $rows->slice(
                ($parameters['per_page'] ?? get_option('posts_per_page')) * ($parameters['page'] - 1),
                $parameters['per_page'] ?? get_option('posts_per_page')
            );

            $rows = new LengthAwarePaginator(
                $sliced->values(),
                $sliced->count(),
                $parameters['per_page'] ?? get_option('posts_per_page'),
                $parameters['page']
            );
        }

        // Remove hidden fields before returning the result.
        return $rows;
    }

    /**
     * Include only the selected fields in the result collection.
     * 
     * @param \Illuminate\Database\Eloquent\Collection $rows
     * @param string $fields
     * @return void
     */
    protected function fields($rows, $fields)
    {
        // Filter only the attributes that can be selected.
        $fields = array_intersect(
            $this->builder->getModel()->getSelectableAttributes(),
            $fields
        );

        if (empty($fields)) {
            return $rows;
        }

        return $rows->map->only($fields);
    }
}