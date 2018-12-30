<?php

namespace YoweliKachala\PackageGenerator\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    /**
     * @var bool
     */
    public $timestamps = false;

    public function ModuleAttribute()
    {
        return $this->hasMany('YoweliKachala\PackageGenerator\Models\ModuleAttribute');
    }
}
