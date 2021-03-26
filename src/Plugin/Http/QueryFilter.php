<?php

namespace JamstackPress\Http;

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

        $params = $this->request->get_params();
        // Apply each of the filters specified.
        foreach ($params as $name => $value)
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

        // Paginate the response.
        if (array_key_exists('page', $params)) {
            $perPage = $params['per_page'] ?? get_option('posts_per_page');
            
            return $this->builder->paginate($perPage, ['*'], 'page', $params['page']);
        }

        return $this->builder->get();
    }

    /**
     * Select only the given fields.
     * 
     * @param string $fields
     * @return void
     */
    public function fields($_fields = null)
    {
        if (!$_fields)
            return;

        // Get the current table.
        $model = $this->builder->getModel();

        // Explode the string into an array.
        $fields = explode(',', $_fields);

        // Filter the columns that exist in the schema.
        $columns = array_filter(
            $fields,
            function($column) use ($model) {
                return in_array(
                    $column, 
                    $model->getAttributes()
                );
            }
        );

        // Select the columns
        $this->builder->select(...$columns);
    }
}