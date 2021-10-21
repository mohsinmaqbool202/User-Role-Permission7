<?php

namespace App\Http\Controllers;


use App\Product;
use App\ProductImages;
use Illuminate\Http\Request;


class ProductController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:product-list|product-create|product-edit|product-delete|store-multiple-images', ['only' => ['index','show']]);
        $this->middleware('permission:product-create', ['only' => ['create','store']]);
        $this->middleware('permission:product-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:product-delete', ['only' => ['destroy']]);
        $this->middleware('permission:store-multiple-images', ['only' => ['storeMultipleImages']]);
        $this->middleware('permission:delete-image', ['only' => ['deleteImage']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::latest()->paginate(5);
        return view('admin.products.index',compact('products'))
            ->with('i', (request()->input('page', 1) - 1) * 5);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'name' => 'required',
            'code' => 'required',
            'color' => 'required',
            'price' => 'required',
        ]);

        $data = $request->all();

        #check if status is empty or not
        if(!empty($data['status'])){
           $data['status'] = 1;
        }
        else{
            $data['status'] = 0;
        }

        #image save
        if($request->hasFile('image')) {
            $image_temp = \Request::file('image');
            if($image_temp->isValid())
            {
                $extension = $image_temp->getClientOriginalExtension();
                $file_name = rand(111,99999). '.'. $extension;
                $image_temp->move(public_path('images/backend_images/products'),$file_name);
                $data['image'] = $file_name;
            }
        }
        
        #now save data in DB
        Product::create($data);
        return redirect()->route('products.index')
                        ->with('success','Product created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
         return view('admin.products.show',compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('admin.products.edit',compact('product'));
    
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        request()->validate([
            'name' => 'required',
            'code' => 'required',
            'color' => 'required',
            'price' => 'required',
        ]);


        $product->update($request->all());

        return redirect()->route('products.index')
                        ->with('success','Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();


        return redirect()->route('products.index')
                        ->with('success','Product deleted successfully');
    }


    public function storeMultipleImages(Request $request, $product_id)
    {
        $product = Product::find($product_id);
        if(!$product){
            abort(404);
        }
        $productImages = $product->images;

        #post request
        if ($request->isMethod('post'))
        {
            $this->validate($request, [
                'images' => 'required',
                // 'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
            ]);

            #store images in DB
            if($request->hasfile('images'))
            {

                foreach($request->file('images') as $image)
                {
                    $extension = $image->getClientOriginalExtension();
                    $file_name = rand(111,99999). '.'. $extension;
                    $image->move(public_path('images/backend_images/products'),$file_name);
                    $img_arr[] = $file_name;

                    $p_img = new ProductImages;
                    $p_img->product_id = $product_id;
                    $p_img->image      = $file_name;
                    $p_img->save();
                }
            }

            return redirect()->route('product.store-multiple-images', $product_id)->with('success', 'Your images has been added successfully');
        }

        #get request
        return view('admin.products.add_images', compact('product_id','product','productImages'));
    }

    public function deleteImage($id)
    {
        $image = ProductImages::find($id);
        if(!$image){
            abort(404);
        }

        $image->delete();
        return back()->with('success', 'Image has been deleted.');
    }
}