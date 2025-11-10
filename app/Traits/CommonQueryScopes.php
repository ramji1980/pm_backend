<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait CommonQueryScopes
{
    /**
     * Scope to filter by status.
     *
     * Usage: Model::filterByStatus('active')->get();
     */
    public function scopeFilterByStatus(Builder $query, ?string $status): Builder
    {
        if (!empty($status)) {
            $query->where('status', $status);
        }
        return $query;
    }

    /**
     * Scope to search by title.
     *
     * Usage: Model::searchByTitle('project')->get();
     */
    public function scopeSearchByTitle(Builder $query, ?string $keyword): Builder
    {
        if (!empty($keyword)) {
            $query->where('title', 'LIKE', "%{$keyword}%");
        }
        return $query;
    }
}
