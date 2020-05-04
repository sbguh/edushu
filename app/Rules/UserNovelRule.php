<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Novel;
use App\User;
use App\Models\Rent;
use App\Models\Card;
class UserNovelRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
     public $novel_id;
     public $has_error = false;
     public $out_error="该用户借书已经到达上限无法借出图书";

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
        $card = Card::find($value);
      //  \Log::info("ruls user".$user->limit_count );

      \Log::info("UserNovelRule value:".$value);

      \Log::info("UserNovelRule limit_rent:".$card->rent_limit);

      $rent_count = Rent::where('card_id',$value)->count();

        if($rent_count +1 > $card->rent_limit ){
          $this->has_error =true;
          }

        if($card->active == 0 ||  $card->enable == 0){
          $this->has_error =true;
          $this->out_error="该用户帐户未激活，或者该用户已经失效";
        //  return true;
        }

        if(strtotime($card->end_date)<strtotime("now")){
          $this->has_error =true;
          $this->out_error="该用户已过有效期";
        //  return true;
        }

        if($card->user->deposit == 0){
          $this->has_error =true;
          $this->out_error="借书需要缴纳押金！";
        //  return true;
        }



        if($this->has_error){
          return false;
        }else{
          return true;
        }

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->out_error;
    }
}
