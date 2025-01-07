<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrdersController extends Controller
{
    public function index(){
        return DB::select('SELECT * FROM orders');
    }

    public function store(Request $request)
    {
        $result = DB::insert(
            'INSERT INTO orders (Customer_ID, Deliver_Address, TotalPrice)
             VALUES (?, ?, ?)',
            [
                $request->Customer_ID,
                $request->Deliver_Address,
                $request->TotalPrice,
            ]
        );
        return $result ? response()->json(['success' => true]) : response()->json(['success' => false]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return DB::select('SELECT * FROM orders WHERE Customer_ID = ?', [$id]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $result = DB::update(
            'UPDATE orders 
             SET Customer_ID = ?, Order_Status = ?, Paid_Date = ?, Deliver_Address = ? 
             WHERE Order_ID = ?',
            [
                $request->Customer_ID,
                $request->Order_Status,
                $request->Paid_Date,
                $request->Deliver_Address
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result = DB::delete('DELETE FROM orders 
                              WHERE Order_ID = ?',[$id]);
        return $result ? response()->json(['success' => true]) : response()->json(['success' => false]);
    }
}