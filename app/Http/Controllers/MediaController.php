<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){
        return view('media.index');
    }

    public function edit($id)
    {
    	return view('media.edit')->with('id', $id);
    }

    public function create()
    {
        return view('media.create');
    }
}
