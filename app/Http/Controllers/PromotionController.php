<?php

namespace App\Http\Controllers;

class PromotionController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

      public function index($id='')
    {
        return view("promotions.index")->with('id',$id);
    }

    public function edit($id)
    {
        return view('promotions.edit')->with('id', $id);
    }

    public function create($id='')
    {
        return view('promotions.create')->with('id',$id);
    }

}


