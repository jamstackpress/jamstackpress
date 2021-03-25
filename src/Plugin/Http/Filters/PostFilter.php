<?php

namespace JamstackPress\Http\Filters;

use JamstackPress\Http\QueryFilter;

/**
 * @since 0.0.1
 */
class PostFilter extends QueryFilter
{
    /**
     * Filter by ID.
     * 
     * @param int $id
     * @return void
     */
    public function id($id = null)
    {
        if (!$id)
            return;
            
        $this->builder->where('ID', $id);
    }

    /**
     * Filter by slug.
     * 
     * @param string $slug
     * @return void
     */
    public function slug($slug = null)
    {
        if (!$slug)
            return;

        $this->builder->where('post_name', $slug);
    }

    /**
     * Filter by status.
     * 
     * @param string $status
     * @return void
     */
    public function status($status = null)
    {
        if (!$status)
            return;

        $this->builder->withoutGlobalScope('published')->where('post_status', $status);
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

    /**
     * Include the given relationships.
     * 
     * @param string $relationships
     * @param string $fields
     * @return void
     */
    public function include($relationships = null)
    {
        if (!$relationships)
            return;

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
                    $columns .= ",{$childPrimaryKey}";
                }

                // Add the foreign key if not exists.
                $parentForeignKey = $model->$relationship()->getForeignKeyName();
                if (!strpos($columns, $parentForeignKey)) {
                    $columns .= ",{$parentForeignKey}";
                }

                // Relationship with some columns.
                $this->builder->with($relationship, function($query) use ($related, $columns) {
                    // Filter the columns that exist in the schema of the related model.
                    $columns = array_filter(
                        explode(',', $columns),
                        function($column) use ($related) {
                            return in_array(
                                $column, 
                                $related->getAttributes()
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