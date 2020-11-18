<?php

namespace App\Http\Controllers;

use App\Category;
use App\Image;
use App\Product;
use App\Unit;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products=Product::paginate(15);
        return view('admin.products.products',['products'=>$products]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $product=null;
        $units=Unit::all();
        $categories=Category::all();
        return view('admin.products.newproduct',[
            'product'=>$product,
            'units'=>$units,
            'categories'=> $categories]);
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
            'product_title'=>'required',
            'product_description'=>'required',
            'product_unit'=>'required',
            'product_price'=>'required',
            'product_total'=>'required',
            'product_category'=>'required',
        ]);
        $product=new Product();
        $product->title=$request->input('product_title');
        $product->description=$request->input('product_description');
        $product->unit=intval($request->input('product_unit'));
        $product->price=doubleVal($request->input ('product_price'));
        $product->total=doubleval($request->input('product_total'));
        $product->category_id=intval($request->input('product_category'));



        $product->save();
        if($request->hasFile('product_images')){
            $images=$request->file('product_images');
            foreach ($images as $image){
                $path=$image->store('public');
                $image=new Image();
                $image->url=$path;
                $image->product_id=$product->id;
                $image->save();

            }

        }

        Session()->flash('message','Product has been added');
        return redirect(route('products.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product=Product::with([ 'hasUnit',
            'category'])->find($id);
        $units=Unit::all();
        $categories=Category::all();
return view('admin.products.newproduct',[
    'product'=>$product,
    'units'=>$units,
    'categories'=>$categories]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'product_title' => 'required',
            'product_description' => 'required',
            'product_unit' => 'required',
            'product_price' => 'required',
            'product_discount' => 'required',
            'product_total' => 'required',
            'product_category' => 'required',
        ]);
        $product=Product::find($id);
        dd('ok');
        $product->title=$request->input('product_title');
        $product->description=$request->input('product_description');
        $product->unit=intval($request->input('product_unit'));
        $product->price=doubleVal($request->input ('product_price'));
        $product->total=doubleval($request->input('product_total'));
        $product->category_id=intval($request->input('product_category'));
        $product->save();
        return redirect()->route('products.index ');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $product=Product::destroy($id);

        return redirect()->route('products.index');
    }
}
