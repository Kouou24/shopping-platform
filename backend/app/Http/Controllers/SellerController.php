<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sellers;
use Illuminate\Support\Facades\DB;


class SellerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $sellers;
    public function __construct() 
    {
        $this->sellers = new Sellers();
    }

    public function index()
    {
        return $this->sellers->all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $result = DB::insert(
            'INSERT INTO sellers (Member_ID, Seller_description)
             VALUES(?, ?)',
             [
                $request->Member_ID,
                $request->Seller_description,
             ]
        );
        return $result ? response()->json(['success' => true]) : response()->json(['success' => false]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $sellers = $this->sellers->find($id); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $sellers = $this->sellers->find($id);
        $sellers->update($request->all());
        return $sellers;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $sellers = $this->sellers->find($id);
        return $sellers->delete();
    }
}
