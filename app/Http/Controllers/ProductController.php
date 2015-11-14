<?php

namespace App\Http\Controllers;

use Session;
use Storage;
use Validator;
use App\Product;
use App\Utilities\ImageUtil;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    use ImageUtil;

    protected $rules = [
        'create' => [
            'name' => 'required|unique:product',
            'description' => 'required|max:255',
            'stock' => 'required|integer|min:0',
            'unit' => 'required',
            'price' => 'required|integer|min:0',
            'product_img' => 'image|mimes:jpeg'
        ],
        'update' => [
            'name' => 'required',
            'description' => 'required|max:255',
            'stock' => 'required|integer|min:0',
            'unit' => 'required',
            'price' => 'required|integer|min:0'
        ]
    ];

    protected $messages = [
        'create' => [
            'name.required' => 'Nama produk tidak boleh kosong',
            'name.unique' => 'Produk dengan nama :attribute sudah ada',
            'description.required' => 'Keterangan produk tidak boleh kosong',
            'description.max' => 'Keterangan produk maksimal 255 karakter',
            'stock.required' => 'Stok tidak boleh kosong',
            'stock.integer' => 'Stok harus berupa bilangan bulat',
            'stock.min' => 'Jumlah stok minimal 0',
            'price.required' => 'Harga produk tidak boleh kosong',
            'price.integer' => 'Harga harus berupa angka',
            'price.min' => 'Harga minimal 0',
            // 'product_img.required' => 'Gambar produk tidak boleh kosong',
            'product_img.image' => 'Gambar harus berupa file gambar',
            'product_img.mimes' => 'Gambar harus berupa file gambar dgn format jpeg (*.jpg, *.jpeg)'
        ],
        'update' => [
            'name.required' => 'Nama produk tidak boleh kosong',
            'description.required' => 'Keterangan produk tidak boleh kosong',
            'description.max' => 'Keterangan produk maksimal 255 karakter',
            'stock.required' => 'Stok tidak boleh kosong',
            'stock.integer' => 'Stok harus berupa bilangan bulat',
            'stock.min' => 'Jumlah stok minimal 0',
            'price.required' => 'Harga produk tidak boleh kosong',
            'price.integer' => 'Harga harus berupa angka',
            'price.min' => 'Harga minimal 0'
        ]
    ];

    public function __construct()
    {
        $this->middleware('admin', ['except' => ['showProduct', 'showRecentProduct']]);
    }


    /**
     * Sanitize the given $limit value to make sure $limit value
     * doesn't have negative value or more than 24 item
     * per page.
     * 
     * @param  int $limit
     * @return int      
     */
    protected function sanitizeLimit($limit)
    {
        if($limit <= 0) {
            $limit = 8;
        } else if($limit > 24) {
            $limit = 24;
        }

        return $limit;
    }

    /**
     * Search product by given name, an limit the output
     * 
     * @param  Request $request
     * @param  int  $limit  
     * @return mixed          
     */
    protected function searchProduct(Request $request, $limit)
    {
        $search_query = '%' . $request->input('q') . '%';

        $products = Product::where('name', 'like', $search_query)
            ->paginate($limit);

        $products->appends(['q' => $request->input('q')]);

        return $products;
    }

    /**
     * Show the recent list of product for user
     * 
     * @return \Illuminate\Http\Response
     */
    public function showRecentProduct()
    {
        $products = Product::latest()
                        ->take(8)
                        ->get();

        return view('tokostar.home', compact('products'));
    }

    /**
     * Get paginated and searchable product
     * 
     * @param  Illuminate\Http\Request $request
     * @param  int $defaultLimit
     * @return mixed
     */
    protected function getPaginatedProducts(Request $request, $defaultLimit=5)
    {
        $limit = $request->input('limit') ? $this->sanitizeLimit($request->input('limit')) : $defaultLimit;

        $products = Product::paginate($limit);

        if($request->has('q')) {
            $products = $this->searchProduct($request, $limit);
        }

        if($limit != $defaultLimit) {
            $products->appends(['limit' => $limit]);
        }

        return $products;
    }

    /**
     * Show the product list to users
     *
     * @param Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function showProduct(Request $request)
    {
        $products = $this->getPaginatedProducts($request, 8);

        return view('tokostar.product', compact('products'));
    }

    /**
     * Display a listing of the resource.
     *
     * @param Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = $this->getPaginatedProducts($request);

        return view('tokostar.admin.productlist', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tokostar.admin.productcreate');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
                        $request->all(),
                        $this->rules['create'], 
                        $this->messages['create']
                    );

        if($validator->fails()) {
            return redirect('/admin/product/create')
                ->withErrors($validator)
                ->withInput();
        }

        $this->handleUploadedImage($request);

        $product = Product::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'stock' => $request->input('stock'),
            'unit' => $request->input('unit'),
            'price' => $request->input('price'),
            'img_name' => $request->input('name')
        ]);

        if($request->has('categories')) {
            $product->categories()->sync($request->input('categories'));
        }

        Session::flash('message', 'Produk berhasil di simpan');

        return redirect('/admin/product');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);

        return $product;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);

        return view('tokostar.admin.productedit', compact('product'));
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
        $product = Product::findOrFail($id);

        $validator = Validator::make(
                        $request->all(),
                        $this->rules['update'], 
                        $this->messages['update']
                    );

        if($validator->fails()) {
            return redirect('/admin/product/' . $id . '/edit')
                ->withErrors($validator)
                ->withInput();
        }

        $product->update($request->all());

        if($request->has('categories')) {
            $product->categories()->sync($request->input('categories'));
        }

        if($request->has('product_img')) {
            $this->handleUploadedImage($request);
            $product->update(['img_name' => $request->input('name')]);
        }

        Session::flash('message', 'Produk berhasil di update');

        return redirect('/admin/product');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if(file_exists(public_path('data/products/' . $product->img_name . '_large.jpg')) &&
            file_exists(public_path('data/products/thumbnail/' . $product->img_name . '_thumb.jpg'))) {

            unlink(public_path('data/products/' . $product->img_name . '_large.jpg'));
            unlink(public_path('data/products/thumbnail/' . $product->img_name . '_thumb.jpg'));

        }

        $product->delete();

        Session::flash('message', 'Produk berhasil dihapus');

        return redirect('/admin/product');
    }
}
