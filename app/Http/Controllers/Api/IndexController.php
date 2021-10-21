<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Response;
use App\Product;
use App\ProductImages;
use App\WishList;
use App\Services\IndexService;


class IndexController extends Controller
{
    protected $indexService;

    public function __construct(IndexService $indexService)
    {
        $this->indexService = $indexService;
    }


    public function index()
    {   
        $result = $this->indexService->gettAllProducts();
        return Response::json($result);
    }

    public function productDetail($id)
    {
        $result = $this->indexService->getProductById($id);
        return Response::json($result);
    }

    #wishlist functions
    public function addToWishList(Request $request)
    {
        $result = $this->indexService->saveProductToWishList($request);
        return Response::json($result);
    }

    public function viewWishList(Request $request)
    {
        $result = $this->indexService->viewAllWishList($request);
        return Response::json($result);
    }

    public function deleteWishList($id)
    {
        $result = $this->indexService->deleteFromWishList($id);
        return $result;
    }
}
