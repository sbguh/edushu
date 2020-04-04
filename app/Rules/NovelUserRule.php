<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\NovelUser;
use App\Models\Novel;
use App\User;

class NovelUserRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
     public $user_id;
     public $has_error = false;
    public function __construct($user_id)
    {
        //
      //   \Log::info($user_id);
         $this->user_id = $user_id;
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

      //  \Log::info("attribute:".$attribute);
      //  \Log::info("attribute value:".$value);

      $user = User::find($this->user_id);

      if(($user->rent_count +1) <= $user->limit_count ){
        $this->has_error =true;

      }else{
        $this->has_error =false;
        return $this->has_error;
      }

        $novel =Novel::find($value);
        $novel->rent_count =$novel->rent_count + 1;
        if($novel->rent_count > $novel->stock){
          $this->has_error =false;
          //return false;
        }else{
          //return true;
          $this->has_error =true;
        }
        return $this->has_error;

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return '您借书已经到达上限或者图书库存不足，无法借出图书!';
    }
}
