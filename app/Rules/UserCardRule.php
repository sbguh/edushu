<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Card;
use App\User;

class UserCardRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
     public $user_id;
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

      //  \Log::info("attribute:".$attribute);
      //  \Log::info("attribute value:".$value);

      if(Card::where('user_id',$value)->count()){
        return false;
      }else{
        return true;
      }

        /*
        if($novel->current_rent >= $novel->stock){
          //$this->has_error =false;
          return false;
        }else{
          return true;
        //  $this->has_error =true;
        }
        //return $this->has_error;

        */

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return '该用户已有会员卡!';
    }
}
