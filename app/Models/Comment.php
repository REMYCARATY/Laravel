<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected static function booted() {
        //un commentaire ne peut être crée par un utilisateur qui n'est pas dans le même groupe
        static::creating(function ($comment) {
            return !is_null($comment->photo->group->users->find($comment->user_id));
        });
    }

    /**
     * Un commentaire appartient à une photo
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
     public function photo()
     {
         return $this->belongsTo(Photo::class);
     }

    /**
     * Un commentaire appartient à un utilisateur
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
     public function user()
     {
         return $this->belongsTo(User::class);
     }

    /**
     * Un commentaire sous un commentaire est une réponse et appartient à son parent
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function replyTo()
     {
        return $this->belongsTo(Comment::class,'comment_id','id');
     }

    /**
     * Un commentaire possède des réponses
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies()
     {
         return $this->hasMany(Comment::class);
     }
}
