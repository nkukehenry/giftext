<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $guarded = [];
    public $timestamps = false;

    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }
}
