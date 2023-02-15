<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductVariantPrice;
use App\Models\Variant;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        // dd($request->input('title'));
        $products = Product::with('product_variant_price');
        if(!empty($_GET['title'])){
            $products = $products->where('products.title','LIKE',$_GET['title']);
        }
        if(!empty($_GET['date'])){
            $products = $products->where('products.created_at','<',$_GET['date']);
        }
        if(!empty($_GET['price_from']) && !empty($_GET['price_to'])){
            $products = $products->whereBetween('product_variant_prices.price', [$_GET['price_from'], $_GET['price_to']]);
        }
        $products = $products->paginate(2);
        // $all_variant_tags = DB::select(
        //     "SELECT product_variants.variant, product_variants.variant_id
        //     FROM product_variants
        //     GROUP by product_variants.variant, product_variants.variant_id
        //     ORDER BY product_variants.variant_id ASC"
        // );
        $all_variant_tags = ProductVariant::select('variant','variant_id')
            ->groupBy('variant','variant_id')
            ->orderBy('variant_id' ,'ASC')->get();
        $all_variants = Variant::all();
        return view('products.index',compact('products','all_variant_tags','all_variants'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        $variants = Variant::all();
        return view('products.create', compact('variants'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $post = $request->all();
        $product_data = new Product();
        $product_data->title = $post['product_name'];
        $product_data->sku = $post['product_sku'];
        $product_data->description = $post['product_description'];
        $product_data->save();
        $product_id = $product_data->id;

        $variant_data = array();
        $variant_prices_data = [];
        $product_variant = $post['product_variant'];
        $variant_prices = $post['product_preview'];
        foreach($product_variant as $varient){
            $variant_id = $varient['option'];
            foreach($varient['value'] as $v=>$vari){
                $variant_data[] = [
                    'variant'=>$vari,
                    'variant_id'=>$variant_id,
                    'product_id'=>$product_id
                ];
            }
        }

        ProductVariant::insert($variant_data);
        $lastId = ProductVariant::orderByDesc('id')->first()->id;
        $ids = range($lastId - count($variant_data) + 1, $lastId);
        $vp=0;$id_one=NULL;$id_two=NULL;$id_three = NULL;
        foreach($variant_prices as $variant_price){
            if(count($ids)<=2){
                $id_one = $ids[0] ?? NULL;
                $id_two = $ids[1] ?? NULL;
            }
            if(count($ids)<=4){
                $id_one = $ids[0+($vp*1)] ?? NULL;
                $id_two = $ids[2+($vp*1)] ?? NULL;
            }
            if(count($ids)>4){
                $id_one = $ids[0+($vp*1)] ?? NULL;
                $id_two = $ids[2+($vp*1)] ?? NULL;
                $id_three = $ids[4+($vp*1)] ?? NULL;
            }
            $variant_prices_data[] = [
                'product_variant_one'=>$id_one ,
                'product_variant_two'=>$id_two ,
                'product_variant_three'=>$id_three ,
                'price'=>$variant_price['price'] ?? 0,
                'stock'=>$variant_price['stock'] ?? 0,
                'product_id'=>$product_id
            ];
            if(count($ids)<=2){
                $vp=0;
            }else if(count($ids)==(3+($vp*1))){
                $vp=0;
            }else if(count($ids)==(5+($vp*1))){
                $vp=0;
            }else{
                $vp++;
            }
        }
        ProductVariantPrice::insert($variant_prices_data);

        return redirect()->route('product.index');
    }


    /**
     * Display the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show($product)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $edit_product = Product::with('product_variant_price')->where('products.id','=',$product->id)->first();
        $variants = Variant::all();
        return view('products.edit', compact('variants','edit_product'));
    }

    public function get_tag($variant_id){
        $varient_tag = ProductVariant::select('variant')->where('variant_id','=',$variant_id)->groupBy('variant')->get();
        echo json_encode($varient_tag);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
