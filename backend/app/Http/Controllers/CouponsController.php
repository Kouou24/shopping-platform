<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupons;
use Illuminate\Support\Facades\DB;

class CouponsController extends Controller
{
    protected $coupons;
    public function __construct(){
        $this->coupons = new Coupons();
    }

    public function index(){
        return DB::select('SELECT c.*, p.Product_Name FROM coupons AS c LEFT JOIN products AS p ON c.Product_ID=p.Product_ID');
    }

    public function store(Request $request)
    {
        return DB::insert('INSERT INTO coupons(Member_ID, Coupon_Name, Discount_Code, Discount, Start_time, End_time, Type, Product_ID)
                            VALUES(?, ?, ?, ?, ?, ?, ?, ?)',
                            [
                                $request->Member_ID,
                                $request->Coupon_Name,
                                $request->Discount_Code,
                                $request->Discount,
                                $request->Start_time,
                                $request->End_time,
                                $request->Type,
                                $request->Product_ID,
                            ]);           
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $coupons = DB::select('SELECT c.*, p.Product_Name FROM coupons AS c LEFT JOIN products AS p ON c.Product_ID=p.Product_ID WHERE Member_ID = ?',[$id]);
        return $coupons; 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $coupons = DB::update('UPDATE coupons
                                SET Coupon_Name =?, Discount_Code=?, Discount=?, Start_time=?,End_time=?,Product_ID=?
                                WHERE Coupon_ID =?',
                                [
                                    $request->Coupon_Name,
                                    $request->Discount_Code,
                                    $request->Discount,
                                    $request->Start_time,
                                    $request->End_time, 
                                    $request->Product_ID,
                                    $id   
                                ]
                            );
       
        return $coupons;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $coupons = DB::delete('DELETE FROM coupons WHERE Coupon_ID = ?', [$id]);
        return $coupons;
    }

}
