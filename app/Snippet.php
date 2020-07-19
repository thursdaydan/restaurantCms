<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * App\Snippet
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Snippet filter(\Illuminate\Http\Request $request)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Snippet newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Snippet newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Snippet query()
 * @mixin \Eloquent
 */
class Snippet extends Model
{
    /**
     * The attributes that are used for migration generation.
     *
     * @array
     */
    protected $migrationAttributes = [['name' => '','properties' => []]];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * Return the attributes used to generate a migration.
     *
     * @return array
     */
    public function migrationAttributes()
    {
        return $this->migrationAttributes;
    }

    /**
     * @param  $query
     *
     * @param  Request  $request
     * @return mixed
     */
    public function scopeFilter($query, Request $request)
    {
        return $query;
    }
}
