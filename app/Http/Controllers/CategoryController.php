<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin', ['except' => ['showProductByCategory']]);
    }

    /**
     * Show product that has specific category name
     * 
     * @param  string $name
     * @return Illuminate\Http\Response
     */
    protected function showProductByCategory($name)
    {
        $category = Category::where('title', $name)->first();
        $products = $category->products()->paginate(8);

        return view('tokostar.product', compact('products'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::paginate(20);

        return view('tokostar.admin.categorylist')
            ->with('categories', $categories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::where('parent_id', 0)->get();

        return view('tokostar.admin.categorycreate', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Category::create([
            'title' => $request->input('title'),
            'parent_id' => $request->input('parent_category'),
        ]);

        \Session::flash('message', 'Kategori berhasil ditambah');

        return redirect('/admin/category');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * 
     * @fixme multiple query
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = Category::where('parent_id', 0)->get();
        $selected = Category::findOrFail($id);

        return view('tokostar.admin.categoryedit', compact('categories', 'selected'));
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
        $category = Category::findOrFail($id);

        $category->update($request->all());

        \Session::flash('message', 'Kategori berhasil edit');

        return redirect('/admin/category');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        $category->delete();

        \Session::flash('message', 'Kategori berhasil dihapus');

        return redirect('/admin/category');
    }
}
