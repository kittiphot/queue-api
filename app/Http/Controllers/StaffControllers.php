<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laravel\Lumen\Routing\Controller as BaseController;

class StaffControllers extends BaseController
{
    private $response = array('status' => 1, 'message' => 'success');

    public function staff()
    {
        $results = staff::where('status', 1)->get();
        return response()->json($results);
    }
    
    public function create(Request $request)
    {
        $results = new staff;
        $results ->name = $request->name;
        $results ->username = $request->username;
        $results ->password = $request->password;
        $results ->type = $request->type;
        $results ->status = 1;
        $results ->save();
        return response()->json($this->response); 
    }

    public function edit(Request $request) 
    {
        $results = staff::find($request->id);
        $results->name = $request->name;
        $results ->username = $request->username;
        $results ->password = $request->password;
        $results->type = $request->type;
        $results->status = $request->status;
        $results->save();
        return response()->json($this->response);
    }

    public function delete(Request $request) 
    {
        $results = staff::find($request->id);
        $results->status = 0;
        $results->save();
        return response()->json($this->response);
    }
    
}
