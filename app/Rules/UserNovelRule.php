<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Novel;
use App\User;
use App\Models\Rent;
class UserNovelRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
     public $novel_id;
     public $has_error = false;
    public function __construct()
    {

    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */

    public function passes($attribute, $value)
    {
        //
      //  \Log::info("ruls value".$value);
        $user = User::find($value);
      //  \Log::info("ruls user".$user->limit_count );

      \Log::info("UserNovelRule value:".$value);

      $rent_count = Rent::where('user_id',$value)->count();

        if($rent_count +1 <= $user->limit_count ){
           return true;
        }else{
          return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return '该用户借书已经到达上限无法借出图书!';
    }
}
