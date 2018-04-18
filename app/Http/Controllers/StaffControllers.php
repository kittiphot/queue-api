<?php

namespace App\Http\Controllers;

class StaffController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function staff()
  {
    $results = staff::where('status', 1)->get();
    return response()->json($results);
  }

  public function create(Request $request)
  {
    $result = new staff;
    $result->caption = $request->caption;
    $result->save();
    return response()->json($this->response); 
  }
  
  public function edit(Request $request) 
  {
    $results = staff::find($request->id);
    $results->caption = $request->caption;
    $results->status = 1;
    $results->save();
    return response()->json($this->response);
  }
  
  public function delete($id) 
  {
    $results = staff::find($id);
    $results->status = 0;
    $results->save();
    return response()->json($this->response);
  }

    //
}
