<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Administrator;

class AdministratorController extends Controller
{
    protected $administrator;
    public function __construct(){
        $this->administrator = new Administrator();
    }

    public function index(){
        return $this->administrator->all();
    }

    public function store(Request $request)
    {
        return $this->administrator->create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $administrator = $this->administrator->find($id); 
    }
}
