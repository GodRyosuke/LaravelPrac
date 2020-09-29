<?php

namespace App\Http\Controllers;

use App\Authors;
use Illuminate\Http\Request;

class testDatabaseController extends Controller
{
    public function index() {
        $authors = \App\Authors::all();
        return view('testDatabase.index', compact('authors'));
    }

    public function process(Request $request) 
    {
        Authors::create($request->all());
        return redirect('/data');
    }
}
