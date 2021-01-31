<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;

    protected static function booted() {
        //une photo ne peut être crée par un utilisateur qui n'est pas dans le groupe
        static::creating(function ($photo) {
            return !is_null($photo->group->users->find($photo->user_id));
        });
    }

    /**
     * Une photo possède des commentaires
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments() {
        return $this->hasMany(Comment::class);
    }
    /**
     * 
     * Une photo appartient à un groupe
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group() {
        return $this->belongsTo(Group::class);
    }

    /**
     * Une photo appartient à l'utilisateur qui l'a posté
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Une photo posté par un user appartient aux utilisateurs apparaissant dessus
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users(){
        return $this->belongsToMany(User::class)->using(PhotoUser::class)->withPivot("id")->withTimestamps();
    }

    /**
     * Une photo appartient à plusieurs tags
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags(){
        return $this->belongsToMany(Tag::class)->using(PhotoTag::class)->withPivot("id")->withTimestamps();
    }
    
}
 