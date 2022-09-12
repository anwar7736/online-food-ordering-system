<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Datatables, Validator, Storage;
class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::orderBy('id', 'desc')->get();
        if(request()->ajax())
        {
            return Datatables()
            ->of($categories)
            ->addColumn('action', function($category){
                $button = "<button data-id='{$category->id}' class='btn btn-success btn-sm edit'>Edit</button>";
                $button .="&nbsp; &nbsp";
                $button .= "<button data-id='{$category->id}' class='btn btn-danger btn-sm delete'>Delete</button>";
                return $button;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view ('admin.category');
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_name' => 'required|unique:categories|min:3'
        ]);
        if($validator->fails())
        {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        else{
            Category::create($request->all());
            return response()->json(['success' => 'Category inserted successfully']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return response()->json(Category::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'category_name' => 'required|min:3'
        ]);
        if($validator->fails())
        {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        else{
            $category = Category::findOrFail($id);
            $category->category_name = $request->category_name;
            $category->save();
            return response()->json(['success' => 'Category updated successfully']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $products = Product::where('category_id', $id)->get();
        foreach($products as $product)
        {
            if($product->product_image)
            {
                $image_name = explode('/', $product->product_image)[4];
                Storage::delete("public/".$image_name);
            }
        }
        Category::findOrFail($id)->delete();
        
        return response()->json(['success' => 'Category has been deleted']);
    }
}
