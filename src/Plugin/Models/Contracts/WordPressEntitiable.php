<?php

namespace JamstackPress\Models\Contracts;

interface WordPressEntitiable
{
    /**
     * Transform the current model to its WordPress entity.
     * 
     * @return mixed
     */
    public function toWordPressEntity();
}