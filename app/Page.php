<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Page extends Model
{
    use Notifiable;

    public $timestamps = false;

    protected $fillable = [
        'title','body','slug'
    ];
}
