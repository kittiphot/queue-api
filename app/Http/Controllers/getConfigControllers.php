<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laravel\Lumen\Routing\Controller as BaseController;

class getConfigControllers extends Controller
{
    private $response = array('status' => 1, 'message' => 'success');
    public function Config()
    {
        $results = config::all();
        return response()->json($results);
    }

    public function create(Request $request)
    {
        $results = new config;
        $results ->id = $request->id;
        $results ->name = $request->name;
        $results ->value = $request->value;
        $results ->status = $request->status;
        $results ->save();
        return response()->json($this->response); 
    }

    public function edit(Request $request) 
    {
        $results = config::find($request->id);
        $results ->name = $request->name;
        $results ->value = $request->value;
        $results ->status = $request->status;
        $results->save();
        return response()->json($this->response);
    }

   
}