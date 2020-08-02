<?php


namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

/**
 * App\MenuCategory
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int $status_id
 * @property int $menu_id
 * @property int $order
 * @property int $author_id
 * @property \Illuminate\Support\Carbon|null $publish_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\User $author
 * @property-read \App\Menu $menu
 * @property-read \App\MenuStatus $status
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MenuCategory filter(\Illuminate\Http\Request $request)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MenuCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MenuCategory newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\MenuCategory onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MenuCategory ordered($direction = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MenuCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MenuCategory whereAuthorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MenuCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MenuCategory whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MenuCategory whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MenuCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MenuCategory whereMenuId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MenuCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MenuCategory whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MenuCategory wherePublishAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MenuCategory whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MenuCategory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\MenuCategory withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\MenuCategory withoutTrashed()
 * @mixin \Eloquent
 */
class MenuCategory extends Model implements Sortable
{
    use SortableTrait;
    use SoftDeletes;

    public $sortable = [
        'order_column_name' => 'order',
        'sort_when_creating' => true,
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'publish_at',
    ];

    /**
     * The attributes that are protected.
     *
     * @var array
     */
    protected $guarded = [];

    public function status(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(MenuStatus::class);
    }

    public function menu(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }

    public function items(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(MenuItem::class, 'category_id', 'id')->ordered();
    }

    public function author(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

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

        if ($request->filled('status_id')) {
            $query->where('status_id', $request->status_id);
        }

        if ($request->filled('menu_id')) {
            $query->where('menu_id', $request->menu_id);
        }

        if ($request->filled('publish_at')) {
            $publishDates = explode(' - ', $request->publish_at);

            $publishFrom = \Carbon\Carbon::parse($publishDates[0])->format('Y-m-d');
            $publishTo = Carbon::parse($publishDates[1])->format('Y-m-d');

            $query->whereBetween('publish_at', [$publishFrom, $publishTo]);
        }

        if ($request->filled('author_id')) {
            $query->where('author_id', $request->author_id);
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
