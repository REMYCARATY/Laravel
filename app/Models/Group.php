<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    /**
     * Un groupe possède des photos
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function photos() {
        return $this->hasMany(Photo::class);
    }

    /**
     * Un groupe appartient à des utilisateurs (via pivot GoupUser)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users(){
        return $this->belongsToMany(User::class)->using(GroupUser::class)->withPivot("id")->withTimestamps();
    }
}
