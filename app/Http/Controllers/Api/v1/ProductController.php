<?php

namespace App\Http\Controllers\Api\v1;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductResourceCollection;

class ProductController extends Controller
{
	public function index():ProductResourceCollection
	{
		return new ProductResourceCollection(Product::paginate());
	}
    public function show(Product $product):ProductResource
    {
    	return new ProductResource($product);
    }
    public function store(Request $request)
    {
    	 $request->validate([
            'id'                => "required",
            'riceGradeType'     => "required",
            'riceType'          => "required",
            'riceShapeType'     => "required",
            'riceColorType'     => "required",
            'riceTextureType'   => "required",
            'riceQuantity'      => "required",
            'riceUnitType'      => "required",
        ]);

        $product = Product::create($request->all());
        return new ProductResource($product);
    }
    public function update(Product $product,Request $request):ProductResource
    {

        $product->update($request->all()); 

        return new ProductResource($product);
    }
    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json([]);
    }
    public function searchGradeType(Request $request)
    {
        $request->validate([
            "inputRiceGradeType" => "required",
            "inputRiceType" => "required",
            "inputRiceShapeType" => "required",
            "inputRiceTextureType" => "required",
            "inputRiceColorType" => "required",
            "inputRiceQuantity" => "required",

        ]);
        $productsArray = [];
        $products = Product::where('riceGradeType','like','%'.$request->inputRiceGradeType.'%')->where('riceType','like','%'.$request->inputRiceType.'%')->where('riceShapeType','like','%'.$request->inputRiceShapeType.'%')->where('riceTextureType','like','%'.$request->inputRiceTextureType.'%')->where('riceColorType','like','%'.$request->inputRiceColorType.'%')->where('riceQuantity','like','%'.$request->inputRiceQuantity.'%')->get();
        foreach ($products as $product) {
            array_push($productsArray,$product);
        }
        return response()->json(["data"=>$productsArray]);
    }
}
