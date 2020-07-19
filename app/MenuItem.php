<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use App\Http\Helpers\Money;

/**
 * App\MenuItem
 *
 * @property int                    $id
 * @property string                 $name
 * @property string|null            $description
 * @property int                    $status_id
 * @property int                    $menu_id
 * @property int|null               $category_id
 * @property int|null               $parent_id
 * @property string                 $cost
 * @property string                 $price
 * @property int                    $gluten_free
 * @property int                    $vegetarian
 * @property int                    $vegan
 * @property int                    $order
 * @property int                    $author_id
 * @property Carbon|null            $publish_at
 * @property Carbon|null            $created_at
 * @property Carbon|null            $updated_at
 * @property Carbon|null            $deleted_at
 * @property-read User              $author
 * @property-read MenuCategory|null $category
 * @property-read Menu              $menu
 * @property-read MenuStatus        $status
 * @method static Builder|MenuItem filter(\Illuminate\Http\Request $request)
 * @method static Builder|MenuItem newModelQuery()
 * @method static Builder|MenuItem newQuery()
 * @method static \Illuminate\Database\Query\Builder|MenuItem onlyTrashed()
 * @method static Builder|MenuItem ordered($direction = 'asc')
 * @method static Builder|MenuItem query()
 * @method static Builder|MenuItem whereAuthorId($value)
 * @method static Builder|MenuItem whereCategoryId($value)
 * @method static Builder|MenuItem whereCost($value)
 * @method static Builder|MenuItem whereCreatedAt($value)
 * @method static Builder|MenuItem whereDeletedAt($value)
 * @method static Builder|MenuItem whereDescription($value)
 * @method static Builder|MenuItem whereGlutenFree($value)
 * @method static Builder|MenuItem whereId($value)
 * @method static Builder|MenuItem whereMenuId($value)
 * @method static Builder|MenuItem whereName($value)
 * @method static Builder|MenuItem whereOrder($value)
 * @method static Builder|MenuItem whereParentId($value)
 * @method static Builder|MenuItem wherePrice($value)
 * @method static Builder|MenuItem wherePublishAt($value)
 * @method static Builder|MenuItem whereStatusId($value)
 * @method static Builder|MenuItem whereUpdatedAt($value)
 * @method static Builder|MenuItem whereVegan($value)
 * @method static Builder|MenuItem whereVegetarian($value)
 * @method static \Illuminate\Database\Query\Builder|MenuItem withTrashed()
 * @method static \Illuminate\Database\Query\Builder|MenuItem withoutTrashed()
 * @mixin \Eloquent
 */
class MenuItem extends Model implements Sortable
{
    use SortableTrait;
    use SoftDeletes;

    public $sortable = [
        'order_column_name'  => 'order',
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

    public function status(): BelongsTo
    {
        return $this->belongsTo(MenuStatus::class);
    }

    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(MenuCategory::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function setCostAttribute($value): void
    {
        $this->attributes['cost'] = Money::fromPounds($value)->inPence();
    }

    public function setPriceAttribute($value): void
    {
        $this->attributes['price'] = Money::fromPounds($value)->inPence();
    }

    public function getCostAttribute($value): string
    {
        return Money::fromPence($value)->inPoundsAndPence();
    }

    public function getPriceAttribute($value): string
    {
        return Money::fromPence($value)->inPoundsAndPence();
    }

    /**
     * @param           $query
     * @param  Request  $request
     *
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

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
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

        if ($request->filled('gluten_free')) {
            $query->where('gluten_free', true);
        }

        if ($request->filled('vegetarian')) {
            $query->where('vegetarian', true);
        }

        if ($request->filled('vegan')) {
            $query->where('vegan', true);
        }

        if ($request->filled('with_archived')) {
            $query->withTrashed()->orderBy('created_at')->orderBy('deleted_at');
        }

        return $query;
    }
}
