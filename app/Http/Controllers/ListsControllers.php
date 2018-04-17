<?php
namespace App\Http\Controllers;

use App\Models\Lists;
use App\Models\Temp;
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
  
  public function lists($id_service_box = 1, $id_staff = 1)
  {
    date_default_timezone_set("Asia/Bangkok");
    $results = Lists::where('status', 1)->orderby('id', 'asc')->limit(1)->get();
    $values = new Temp;
    $values->id_list = $results['0']['id'];
    $values->queue = $results['0']['queue'];
    $values->id_service_box = $results['0']['id_service_box'];
    $values->save();
    $results = Temp::where('id_service_box', 1)->get();
    if (condition) {
      # code...
    }
    $values = Lists::find($values->id_list);
    $values->id_service_box = $id_service_box;
    $values->id_staff = $id_staff;
    $values->call_time = date("Y-m-d h:i:s");
    $values->save();
    // $result->id_service_box = $request->id_service_box;
    // $result->id_staff = $request->id_staff;
    // $results->call_time = date("Y-m-d h:i:s");
    // $result->end_time = $request->end_time;
    // $results->save();
    return response()->json($values); 
    // return response()->json($this->response); 
  }

  public function edit()
  {
    $results = NewsCategory::find($request->id);
    $results->caption = $request->caption;
    $results->status = 1;
    $results->save();
    return response()->json($this->response);
  }

  public function create(Request $request)
  {
    $result = new Lists;
    $result->queue = $request->queue;
    $result->status = $request->status;
    $values->create_time = date("Y-m-d h:i:s");
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