<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BelongToController extends Controller
{
    public function index()
    {
        return DB::select('SELECT * FROM Belong_to');
    }

    public function store(Request $request)
    {
        $result = DB::insert(
            'INSERT INTO Belong_to(Product_ID, Order_ID, Quantity, Order_Status) 
            VALUES (?, ?, ?, ?)',
            [
                $request->Product_ID,
                $request->Order_ID,
                $request->Quantity, 
                $request->Order_Status,
            ]
        );
        return $result ? response()->json(['success' => true]) : response()->json(['success' => false]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return DB::select('SELECT * FROM Belong_to WHERE Order_ID = ?', [$id]);
    }

    public function update(Request $request)
    {
        $result = DB::update('UPDATE Belong_to 
                            SET Order_Status = ?
                            WHERE Product_ID = ? AND Order_ID = ?',
                            [
                                $request->Order_Status,
                                $request->Product_ID,
                                $request->Order_ID,
                            ]
                );
    }

    public function destroy(Request $request)
    {
        $result = DB::delete('DELETE FROM Belong_to 
                              WHERE Product_ID = ? AND Order_ID = ?',
                              [
                                $request -> query('Product_ID'),
                                $request -> query('Order_ID'),
                              ]
                            );
        return $result ? response()->json(['success' => true]) : response()->json(['success' => false]);
    }
}