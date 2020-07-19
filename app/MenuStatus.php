<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\MenuStatus
 *
 * @property int $id
 * @property string $name
 * @property string $text_colour
 * @property string $background_colour
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MenuStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MenuStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MenuStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MenuStatus whereBackgroundColour($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MenuStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MenuStatus whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MenuStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MenuStatus whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MenuStatus whereTextColour($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MenuStatus whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MenuStatus extends Model
{
    /**
     * The attributes that are protected.
     *
     * @var array
     */
    protected $guarded = [];
}
