<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class MarketController extends Controller
{
    //
    public function index(Request $request)
    {
      return view('market.index');
    }

    public function search(Request $request)
    {

      $barcode = $request->input('barcode');

      $product = Item::where('barcode',trim($barcode))->first();
      if($product==false){
        $python_fetch = base_path()."/chaoshi.py 2>&1 ".$barcode;
      //  echo $python_fetch;
        exec('python3 '.$python_fetch ,$output, $return_var);
        $data = json_decode($output[0]);
        $product =  Item::create([
                     'barcode' => $barcode,
                     'name' =>$data->name,
                   //  'level_star'=>$level_star
             //      'version' => $crawl_version,
               ]);

      }
      return json_encode($product);
      //return view('market.search', ['product' => $product]);
      //echo $data->name;
      //$data_json =json_decode($data,true);
  //    var_dump($data);
    //  return $data;


    }

    public function update(Request $request)
    {

      $ProductSalePrice = $request->input('ProductSalePrice');
      $ProductName = $request->input('ProductName');
      $barcode = $request->input('ProductBarcode');

      $product = Item::where('barcode',trim($barcode))->first();

      if($product==false){
      //  echo $python_fetch;

        $product =  Item::create([
                     'barcode' => $barcode,
                   //  'level_star'=>$level_star
             //      'version' => $crawl_version,
               ]);

      }

      $product->name = $ProductName;
      $product->sale_price = $ProductSalePrice;
      $product->save();
      return json_encode($product);
      //return view('market.search', ['product' => $product]);
      //echo $data->name;
      //$data_json =json_decode($data,true);
  //    var_dump($data);
    //  return $data;


    }

}
