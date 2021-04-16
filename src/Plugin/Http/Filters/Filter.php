<?php

namespace JamstackPress\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
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
            // If the filter is not defined, continue looping.
            if (!method_exists($this, $parameter)) {
                continue;
            }

            $method = Str::camel($parameter);

            // We're going to handle the fields method afterwards.
            if ($method == 'fields') {
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

        // For last, check if there's a page filter.
        if (in_array('page', array_keys($parameters))) {
            // Paginate the results.
            $rows = $this->builder->paginate(
                $parameters['per_page'] ?? get_option('posts_per_page'),
                ['*'],
                'page',
                $parameters['page']
            );
        } else {
            $rows = $this->builder->get();
        }

        /* If the fields method was specified, get only the
         * corresponding fields. */
        if (isset($fields)) {
            // Check if there are selectable attributes.
            $attributes = array_intersect(
                $this->builder->getModel()->getSelectableAttributes(),
                $fields
            );

            /* If there are attributes, get them, otherwise return all
             * the attributes */
            if ($attributes) {
                // If the result is paginated, we need another treatment.
                if ($rows instanceof \Illuminate\Pagination\LengthAwarePaginator) {
                    return $rows->setCollection(
                        $rows->getCollection()->map->only($attributes)
                    );
                }

                return $rows->map->only($attributes);
            }
        }

        // If there are no fields specified, return all of them.
        if ($rows instanceof \Illuminate\Pagination\LengthAwarePaginator) {
            return $rows->setCollection(
                $rows->getCollection()->map->only(
                    $this->builder->getModel()->getSelectableAttributes()
                )
            );
        }

        return $rows->map->only($this->builder->getModel()->getSelectableAttributes());
    }

    /**
     * Select only a set of fields from the model.
     * 
     * @param string $fields
     * @return void
     */
    public function fields($fields)
    {
        $attributes = $this->builder->getModel()->getFillable();
        $columns = explode(',', $fields);

        // Select only the columns that exist in the model.
        $columns = array_filter(
            $columns,
            function($column) use ($attributes) {
                return in_array(
                    $column,
                    $attributes
                );
            }
        );

        // Make the query.
        $this->builder->select(...$columns);
    }

    /**
     * Include the relationships given. Optionally, select only
     * a set of fields of each relationship.
     * 
     * @param string $relationships
     * @return void
     */
    public function include($relationships)
    {
        // Get the builder model.
        $model = $this->builder->getModel();

        // Loop the relationships and include the ones that exist.
        foreach (explode(';', $relationships) as $value) {
            // Check if the relationship contains custom fields.
            if (strpos($value, ':')) {
                $parts = explode(':', $value);
                $relationship = $parts[0];
                $columns = $parts[1];

                // Continue if the relationship doesn't exist.
                if (!method_exists($model, $parts[0])) {
                    continue;
                }
                
                /* If we select custom columns on a relationship, Eloquent needs
                 * the child's primary key and the parent foreign key to work.
                 * Otherwise, it will return a null object.
                 * This way, we don't need to ask the user to send the primary
                 * and foreign key in the included fields of each relationship. */

                // Add the related primary key.
                $related = $model->$relationship()->getRelated();
                $childPrimaryKey = $related->getKeyName();
                if (!strpos($columns, $childPrimaryKey)) {
                    $columns .= ",{$related->getQualifiedKeyName()}";
                }

                // Add the foreign key if not exists.
                $parentForeignKey = $model->$relationship()->getForeignKeyName();
                if (!strpos($columns, $parentForeignKey)) {
                    $columns .= ",{$model->$relationship()->getQualifiedForeignKeyName()}";
                }

                // Relationship with some columns.
                $attributes = $related->getAttributes();
                $this->builder->with($relationship, function($query) use ($attributes, $columns) {
                    // Filter the columns that exist in the schema of the related model.
                    $columns = array_filter(
                        explode(',', $columns),
                        function($column) use ($attributes) {
                            return in_array(
                                $column, 
                                $attributes
                            );
                        }
                    );

                    $query->select(...$columns);
                });
            } else {
                $relationship = $value;

                // Continue if the relationship doesn't exist.
                if (!method_exists($model, $relationship)) {
                    continue;
                }

                // Relationship with all columns.
                $this->builder->with($relationship);
            }
        }
    }
}