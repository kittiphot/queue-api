<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\config;
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


        // $results = config::where('name', 'queue format')->get();
        // $value= $results['0']['id'];
        // $data = config::find($value);
        // $data ->value = $request->format;
        // $data ->status = 1;
        // $data->save();

        // $results2 = config::where('name', 'queue reset')->get();
        // $value2= $results2['0']['id'];
        // $data = config::find($value2);
        // $data ->value = $request->reset;
        // $data ->status = 1;
        // $data->save();
        // return response()->json($this->response);

    }

   
}