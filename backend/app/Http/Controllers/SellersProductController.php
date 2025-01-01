<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SellersProductController extends Controller
{
    
    public function index()
    {
        return DB::select('SELECT * FROM products');
    }

    public function store(Request $request)
    {
        $result = DB::insert(
            'INSERT INTO products (Seller_ID, Product_Name, Product_Description, Price, Release_date, Stock_quantity, imgLink) 
            VALUES (?, ?, ?, ?, ?, ?, ?)',
            [
                $request->Seller_ID,
                $request->Product_Name,
                $request->Product_Description, 
                $request->Price,
                $request->Release_date,
                $request->Stock_quantity,
                $request->imgLink
            ]
        );
        return $result ? response()->json(['success' => true]) : response()->json(['success' => false]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return DB::select('SELECT * FROM products WHERE Seller_ID = ?', [$id]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $result = DB::update(
            'UPDATE products 
            SET Seller_ID = ?, Product_Name = ?, Product_Description = ?, Price = ?, Release_date = ?, Stock_quantity = ?, imgLink = ?  
            WHERE Product_ID = ?',
            [
                $request->Seller_ID,
                $request->Product_Name,
                $request->Product_Description, 
                $request->Price,
                $request->Release_date,
                $request->Stock_quantity,
                $request->imgLink,
                $id
            ]
       );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result = DB::delete('DELETE FROM products 
                              WHERE Product_ID = ?',[$id]);
        return $result ? response()->json(['success' => true]) : response()->json(['success' => false]);
    }
    
}

