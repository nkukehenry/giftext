<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    //fillable fields name	email	phone	pin	group_id	profile_picture	wishlist	
    protected $fillable = [
        'name',
        'email',
        'phone',
        'pin',
        'group_id',
        'profile_picture',
        'wishlist',
    ];

    protected $appends = ['avatar', 'group_name'];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function getAvatarAttribute()
    {
        return $this->profile_picture ? asset($this->profile_picture) : asset('images/avatar.png');
    }

    public function getGroupNameAttribute()
    {
        return $this->group->name;
    }

    
}
