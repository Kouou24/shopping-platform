<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupons;

class CouponsController extends Controller
{
    protected $coupons;
    public function __construct(){
        $this->coupons = new Coupons();
    }

    public function index(){
        return $this->coupons->all();
    }

    public function store(Request $request)
    {
        return $this->coupons->create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $coupons = $this->coupons->find($id); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $coupons = $this->coupons->find($id);
        $coupons->update($request->all());
        return $coupons;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $coupons = $this->coupons->find($id);
        return $coupons->delete();
    }

}
