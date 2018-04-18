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
    $lists_results = Lists::where('status', 1)->orderby('id', 'asc')->limit(1)->get();
    $temp_results = Temp::where('id_service_box', $id_service_box)->get();
    // return response()->json($lists_results);
    if ($temp_results == '[]') {
      $temp_results = new Temp;
      $temp_results->id_list = $lists_results['0']['id'];
      $temp_results->queue = $lists_results['0']['queue'];
      $temp_results->id_service_box = $id_service_box;
      $temp_results->save();
    }
    else {
      $temp_results = Temp::where('id_service_box', $id_service_box)->get();
      $results = Lists::find($temp_results['0']['id_list']);
      $results->end_time = date("Y-m-d h:i:s");
      $results->save();
      if ($lists_results == '[]') {
        return response()->json($this->response);
        // return response()->json($results);
      }
      $temp_results = Temp::find($temp_results['0']['id']);
      $temp_results->id_list = $lists_results['0']['id'];
      $temp_results->queue = $lists_results['0']['queue'];
      $temp_results->id_service_box = $id_service_box;
      $temp_results->save();
    }
    // return response()->json($lists_results);
    $lists_results = Lists::find($temp_results->id_list);
    $lists_results->id_service_box = $id_service_box;
    $lists_results->id_staff = $id_staff;
    $lists_results->call_time = date("Y-m-d h:i:s");
    $lists_results->status = 0;
    $lists_results->save();
    // return response()->json($lists_results); 
    return response()->json($this->response);
  }

  public function create(Request $request)
  {
    $result = new Lists;
    $result->queue = $request->queue;
    $result->status = 1;
    $result->create_time = date("Y-m-d h:i:s");
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