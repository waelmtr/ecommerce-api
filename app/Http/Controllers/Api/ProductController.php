<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Models\Comments;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //public function check(){
    
   // }
    public function index()
    {
        $currentdate = Carbon::now();
        $product = Product::all();
        foreach($product as $product){
          $date = new Carbon($product['expiration_Date']);
          $firstdate = $date->subDays($product['firstDiscountDate']);
          $seconddate = $date->subDays($product['secondDiscountDate']);
          $thirddate = $date->subDays($product['thirdDiscountDate']);
          if($currentdate===$date){
              $id = $product['id'];
              Product::destroy($id);
            }
            else if($currentdate===$firstdate){
                $id = $product['id'];
                Product::find($id)->update([
                    'Price'=>$product['Price']*$product['firstDiscount']/100
                ]);
            }
            else if($currentdate===$seconddate){
               $id = $product['id'];
                Product::find($id)->update([
                 'Price'=>$product['Price']*$product['secondDiscount']/100
                ]);
            }
            else if($currentdate===$thirddate){
                $id = $product['id'];
                Product::find($id)->update([
                 'Price'=>$product['Price']*$product['thirdDiscount']/100
                ]);
            }
        }
        $products = Product::all();

        return $products;
    }

    public function creatcategory(Request $request){
        $category = Category::create([
            'name'=>$request->input('category')
          ]);
          return response()->json('done' , 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

       $request->validate([
           'name'=>'required' ,
           'image_Path'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
           'expiration_Date'=>'required',
           'firstDiscountDate'=>'required',
           'firstDiscount'=>'required',
           'secondDiscountDate'=>'required',
           'secondDiscount'=>'required',
           'thirdDiscountDate'=>'required',
           'thirdDiscount'=>'required',
           'description'=>'required' ,
           'contact_Information'=>'required',
           'Quantity'=>'required',
           'Price'=>'required' ,
           'category'=>'required'
       ]); 
       $category = $request->get('category');
       $category_id = Category::where('name' , $category)->first()->id; 
      $imageName = time().'.'.$request->image_Path->extension();
       $request->image_Path->move(public_path('images\products'), $imageName);

      $product =  Product::create([
         'name'=>$request->input('name'),
         'image_Path'=>$imageName ,
         'expiration_Date'=>$request->input('expiration_Date'),
         //Discounts
         'firstDiscountDate'=>$request->input('firstDiscountDate'),
         'firstDiscount'=>$request->input('firstDiscount'),
         'secondDiscountDate'=>$request->input('secondDiscountDate'),
         'secondDiscount'=>$request->input('secondDiscount'),
         'thirdDiscountDate'=>$request->input('thirdDiscountDate'),
         'thirdDiscount'=>$request->input('thirdDiscount'),
         //
         'description'=>$request->input('description'),
         'contact_Information'=>$request->input('contact_Information'),
         'Quantity'=>$request->input('Quantity'),
         'Price'=>$request->input('Price'),
         'category_id'=>$category_id,
         'user_id'=>Auth::user()->id
      ]);

       return response()->json("your product is stored successfuly",200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     public function storecomments(Request $request , Product $id){
         $request->validate([
             'comment'=>'string|min:1|max:100'
         ]);
        $comment = $id->comments()->create([
           'comment'=>$request->input('comment'),
           'user_id'=>Auth::id()
        ]);
        return response()->json('done', 200);
     }
   
    public function show($id , Request $request)
    {    
        Product::find($id)->increment('views');
     return  $product  = Product::find($id);
    }    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        $product->update([
            'Quantity'=>$request->input('Quantity'),
            'Price'=>$request->input('Price')
        ]);
        return response()->json('your product updated successfuly', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       Product::destroy($id);
       return response()->json('product deleted successfuly',200);
    }

    public function search(Request $request){
        $search = $request->input('search');
     return product::where('name','like' , '%'.$search.'%')
    // ->orwhere('category_id', Category::where('name' , $search)->first()->id)
     ->orwhere('expiration_Date' , $search)
     ->get();
    }
     
    public function sort(Request $request){
        $sort = $request->input('sort');
        return Product::orderBy($sort)->get();
    }
     
    
   
}
