<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreRequest;
use App\Http\Requests\Product\UpdateRequest;
use App\Models\Product;
use App\Models\User;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    use ApiResponseTrait;

    /**
     * Display a listing of the resource.
     *
     * @return never|ResponseFactory|Response|
     */
    public function index()
    {


        //Product::where('user_id',auth('api')->user()->id)->findOrFill(auth('api')->current_tenant_id)->get();
        $products =  DB::table('products')
            ->where('user_id',auth('api')->user()->id)
            ->where('tenant_id',auth('api')->user()->current_tenant_id)
            ->get();
            return $this->apiResponse($products,'success',200);

    }
    /**
     * Show the form for creating a new resource.
     *->
     * @return void
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(StoreRequest $request)
    {
      $products = Product::create($request->validated());
        return $this->apiResponse($products,'Store has success',201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $products = Product::findorfail($id);
            if ($products) {
            return $this->apiResponse($products,'Response has success',200);
        }
            return $this->apiResponse(null,'Not exist Tenant',204);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return void
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(UpdateRequest $request, Product $product)
    {
        $product->update($request->validated());
        return $this->apiResponse($product,'Update has success',200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @param $products
     * @return Response
     */
    public function destroy(Product $products)
    {
               $products->delete();
        return $this->apiResponse(null,'delete has success',200);
    }
}
