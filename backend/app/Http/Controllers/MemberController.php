<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MemberController extends Controller
{
    public function index()
    {
        // 使用 SQL 查詢所有會員
        return DB::select('SELECT * FROM members');
    }

    public function store(Request $request)
    {
        // 使用 SQL 插入一筆資料
        $result = DB::insert(
            'INSERT INTO members (Nickname, User_Account, User_Password, Email, Address)
             VALUES (?, ?, ?, ?, ?)',
            [
                $request->Nickname, 
                $request->User_Account,
                $request->User_Password,
                $request->Email,
                $request->Address
            ]
        );
        return $result ? response()->json(['success' => true]) : response()->json(['success' => false]);
    }

    public function show(string $id)
    {
        // 使用 SQL 查詢單筆會員資料
        return DB::select('SELECT * FROM members WHERE Member_ID = ?', [$id]);
    }

    public function update(Request $request, string $id)
    {
        // 使用 SQL 更新資料
        $result = DB::update(
            'UPDATE members 
             SET Nickname = ?, User_Account = ?, User_Password = ?, Email = ?, Address = ?  
             WHERE Member_ID = ?',
            [
                $request->Nickname,
                $request->User_Account,
                $request->User_Aassword,
                $request->Email,
                $request->Address,
                $id
            ]
        );
        return $result ? response()->json(['success' => true]) : response()->json(['success' => false]);
    }

    public function destroy(string $id)
    {
        // 使用 SQL 刪除資料
        $result = DB::delete('DELETE FROM members 
                              WHERE Member_ID = ?',[$id]);
        return $result ? response()->json(['success' => true]) : response()->json(['success' => false]);
    }
}
