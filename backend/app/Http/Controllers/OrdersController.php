<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orders;

class OrdersController extends Controller
{
    protected $orders;
    public function __construct(){
        $this->orders = new Orders();
    }

    public function index(){
        return $this->orders->all();
    }

    public function store(Request $request)
    {
        return $this->orders->create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $orders = $this->orders->find($id); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $orders = $this->orders->find($id);
        $orders->update($request->all());
        return $orders;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $orders = $this->orders->find($id);
        return $orders->delete();
    }
}
