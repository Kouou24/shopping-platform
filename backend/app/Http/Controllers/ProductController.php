<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
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
        return DB::select('SELECT * FROM products WHERE Product_ID = ?', [$id]);
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

    public function orderProductCustomer(string $id)
    {
        return DB::select('SELECT * FROM products 
                            JOIN belong_to ON 
                            products.Product_ID = belong_to.Product_ID
                            where Order_ID = ?',[$id]);
    }
    public function orderProductSeller(string $id)
    {
        return DB::select('SELECT p.Product_ID, p.Seller_ID, p.Product_Name, p.Price, blong.Quantity, o.Customer_ID, blong.Order_Status, o.Order_ID
FROM products as p JOIN belong_to as blong ON p.Product_ID=blong.Product_ID JOIN orders as o ON blong.Order_ID = o.Order_ID 
where p.Seller_ID=?',[$id]);
    }
}
