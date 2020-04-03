<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class NovelUserHistory extends Pivot
{
    //

    protected $fillable = [
                    'novel_id','user_id', 'type'

                      ];

    protected $table = 'novel_user_history';

}
