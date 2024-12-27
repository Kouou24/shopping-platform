<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $products;
    public function __construct() 
    {
        $this->products = new Products();
    }

    public function index()
    {
        return $this->products->all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return $this->products->create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $products = $this->products->find($id); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $products = $this->products->find($id);
        $products->update($request->all());
        return $products;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $products = $this->products->find($id);
        return $products->delete();
    }
}
