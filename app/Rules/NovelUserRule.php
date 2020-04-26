<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\NovelUser;
use App\Models\Novel;
use App\Models\Rent;
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

      \Log::info("NovelUserRule value:".$value);
        $rent_count = Rent::where('novel_id',$value)->where('state', '借阅中')->count();
        $novel =Novel::find($value);
      //  $novel->stock =$novel->stock - 1;
        if(($rent_count + 1)<= $novel->stock ){
          //$this->has_error =false;
          return true;
        }else{
          return false;
        //  $this->has_error =true;
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
        return '图书库存不足，无法借出图书!';
    }
}
