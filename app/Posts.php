<?php

namespace App;

use App\Scopes\PostScope;
use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    protected $table = 'posts';

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'body'
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new PostScope);
    }
}
