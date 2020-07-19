<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * App\page
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\page filter(\Illuminate\Http\Request $request)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\page newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\page newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\page query()
 * @mixin \Eloquent
 */
class page extends Model
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
