<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommentFile extends Model
{
    //
    protected $table = 'comment_files';
    protected $fillable = [
        'comment_id',
        'file',
        'type',
    ];

}
