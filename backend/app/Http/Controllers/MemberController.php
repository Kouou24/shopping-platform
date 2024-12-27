<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;

class MemberController extends Controller
{
    protected $member;
    public function __construct(){
        $this->member = new Member();
    }

    public function index(){
        return $this->member->all();
    }

    public function store(Request $request)
    {
        return $this->member->create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $member = $this->member->find($id); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $member = $this->member->find($id);
        $member->update($request->all());
        return $member;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $member = $this->member->find($id);
        return $member->delete();
    }
}
