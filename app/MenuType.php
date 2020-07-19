<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

/**
 * App\MenuType
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MenuType filter(\Illuminate\Http\Request $request)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MenuType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MenuType newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\MenuType onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MenuType ordered($direction = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MenuType query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MenuType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MenuType whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MenuType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MenuType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MenuType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\MenuType withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\MenuType withoutTrashed()
 * @mixin \Eloquent
 */
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

        if ($request->filled('created_at')) {
            $createdDates = explode(' - ', $request->created_at);

            $createdFrom = Carbon::parse($createdDates[0])->format('Y-m-d');
            $createdTo = Carbon::parse($createdDates[1])->format('Y-m-d');

            $query->whereBetween('created_at', [$createdFrom, $createdTo]);
        }

        if ($request->filled('with_archived')) {
            $query->withTrashed()->orderBy('created_at')->orderBy('deleted_at');
        }

        return $query;
    }
}
