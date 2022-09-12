<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Datatables, Validator, Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('categories')->orderBy('id', 'desc')->get();
        if(request()->ajax())
        {
            return Datatables()
            ->of($products)
            ->addColumn('action', function($product){
                $button = "<button data-id='{$product->id}' class='btn btn-success btn-sm edit'>Edit</button>";
                $button .="&nbsp; &nbsp";
                $button .= "<button data-id='{$product->id}' class='btn btn-danger btn-sm delete'>Delete</button>";
                return $button;
            })
            ->addColumn('image', function($product){
                $image = "<img src='{$product->product_image}' height='100' width='100'/>";
                return $image;
            })
            ->rawColumns(['action', 'image'])
            ->editColumn('category_id',function($product){
                return $product->categories->category_name;
            })
            ->make(true);
        }
        $categories = Category::all();
        return view ('admin.product', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_name' => 'required',
            'product_name' => 'required|unique:products|min:3',
            'product_price' => 'required',
            'product_image' => 'image|mimes:jpeg,png,jpg',
        ]);
        if($validator->fails())
        {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        else{
            $image_path = "";
            if($request->file('product_image'))
            {
                  $image_path = $request->file('product_image')->store('public');
            }

            $image_name = explode("/", $image_path)[1];
            $product = new Product();
            $product->category_id = $request->category_name;
            $product->product_name = $request->product_name;
            $product->product_price = $request->product_price;
            $product->product_image = "http://".$_SERVER['HTTP_HOST']."/storage/". $image_name;
            $product->save();
            return response()->json(['success' => 'Product inserted successfully']);
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        return response()->json(Product::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        Product::findOrFail($id)->delete();
        return response()->json(['success' => 'Product has been deleted']);
    }

    public function getCategoryName()
    {
     
    }
}
