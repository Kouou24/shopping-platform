<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HasCouponController extends Controller
{
    public function index(){
        return DB::select('SELECT * FROM Has_Coupon AS h LEFT JOIN coupons AS c ON c.Coupon_ID=h.Coupon_ID');
    }

    public function store(Request $request)
    {
        return DB::insert('INSERT INTO Has_Coupon(Coupon_ID, Customer_ID, Used)
                            VALUES(?, ?, ?)',
                            [
                                $request->Coupon_ID,
                                $request->Member_ID,
                                $request->Used,
                            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $coupons = DB::select('SELECT * FROM Has_Coupon AS h LEFT JOIN coupons AS c ON c.Coupon_ID=h.Coupon_ID WHERE h.Customer_ID = ?',[$id]);
        return $coupons; 
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $result = DB::update(
            'UPDATE Has_coupon 
            SET Used = ?
            WHERE Coupon_ID = ? AND Customer_ID = ?',
            [
                $request->Used,
                $request->Coupon_ID,
                $request->Customer_ID,
            ]
       );
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $coupons = DB::delete('DELETE FROM Has_Coupon WHERE Coupon_ID = ? AND Customer_ID = ?', 
                    [
                        $request->query('Coupon_ID'),
                        $request->query('Customer_ID'),
                    ]);
        return $coupons;
    }

}