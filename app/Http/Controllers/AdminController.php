<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Survey;

class AdminController extends Controller
{
    /**
     * Admin index
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        $surveys = Survey::all();

        return view('admin.index', compact('surveys'));
    }
}
