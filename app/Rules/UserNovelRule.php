<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Novel;
use App\User;
class UserNovelRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
     public $novel_id;
     public $has_error = false;
    public function __construct($novel_id)
    {
        //
        $this->novel_id = $novel_id;
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
        $user = User::find($value);

        if($user->rent_count +1 <= $user->limit_count ){
          $this->has_error =true;
        }else{
          $this->has_error =false;
          return $this->has_error;
        }

        $novel =Novel::find($this->novel_id);
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
