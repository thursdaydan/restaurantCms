<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Carbon\Carbon;

/**
 * App\Menu
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int $status_id
 * @property int $type_id
 * @property int $order
 * @property string|null $header_text
 * @property string|null $footer_text
 * @property \Illuminate\Support\Carbon|null $publish_at
 * @property int $author_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\User $author
 * @property-read \App\MenuStatus $status
 * @property-read \App\MenuType $type
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Menu filter(\Illuminate\Http\Request $request)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Menu newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Menu newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Menu onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Menu ordered($direction = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Menu query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Menu whereAuthorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Menu whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Menu whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Menu whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Menu whereFooterText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Menu whereHeaderText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Menu whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Menu whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Menu whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Menu wherePublishAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Menu whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Menu whereTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Menu whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Menu withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Menu withoutTrashed()
 * @mixin \Eloquent
 */
class Menu extends Model implements Sortable
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

    public function type(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(MenuType::class);
    }

    public function categories(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(MenuCategory::class)->ordered();
    }

    public function items()
    {
        return $this->hasManyThrough(MenuItem::class, MenuCategory::class, 'menu_id', 'category_id');
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

        if ($request->filled('type_id')) {
            $query->where('type_id', $request->type_id);
        }

        if ($request->filled('publish_at')) {
            $publishDates = explode(' - ', $request->publish_at);

            $publishFrom = Carbon::parse($publishDates[0])->format('Y-m-d');
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
