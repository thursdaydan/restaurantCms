<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class MenuType extends Model implements Sortable
{
    use SortableTrait;
    use SoftDeletes;

    /**
     * The attributes that are protected.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * @param  $query
     *
     * @param  Request  $request
     * @return mixed
     */
    public function scopeFilter($query, Request $request)
    {
        if ($request->filled('name')) {
            $query->where('name', 'like', "%{$request->name}%");
        }

        return $query;
    }
}
