<?php
namespace App\Http\Controllers;

use App\Models\Lists;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class ListsControllers extends BaseController {
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
      //
  }

  private $response = array('status' => 1, 'message' => 'success');
  
  public function lists()
  {
    $results = Lists::where('status', 1)->orderby('id', 'asc')->limit(1)->get();
    // $results = Lists::find(1);
    // $result->id_service_box = $request->id_service_box;
    // $result->id_staff = $request->id_staff;
    // $result->call_time = $request->call_time;
    // $result->end_time = $request->end_time;
    // $result->save();
    return response()->json($results); 
    // return response()->json($this->response); 
  }

  public function create(Request $request)
  {
    $result = new Lists;
    $result->queue = $request->queue;
    $result->status = $request->status;
    $result->save();
    return response()->json($this->response); 
  }
  
  // public function edit(Request $request) 
  // {
  //   $results = NewsCategory::find($request->id);
  //   $results->caption = $request->caption;
  //   $results->status = 1;
  //   $results->save();
  //   return response()->json($this->response);
  // }
  
  // public function delete($id) 
  // {
  //   $results = NewsCategory::find($id);
  //   $results->status = 0;
  //   $results->save();
  //   return response()->json($this->response);
  // }

}