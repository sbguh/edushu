<?php

namespace App\Http\Requests;
use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\Book;

class AddCartRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
      return [
          'book_id' => [
              'required',
              function ($attribute, $value, $fail) {

                  if (!$book = Book::find($value)) {
                      return $fail('该商品不存在');
                  }
                  if (!$book->on_sale) {
                      return $fail('该商品未上架');
                  }
                  if ($book->stock === 0) {
                      return $fail('该商品已售完');
                  }
                  if ($this->input('amount') > 0 && $book->stock < $this->input('amount')) {
                      return $fail('该商品库存不足');
                  }
              },
          ],
      ];
    }



}
