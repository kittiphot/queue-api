<?php
namespace App\Http\Controllers;

use App\Models\Lists;
use App\Models\Temp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

  public function list()
  {
    $results = Lists::all();
    return response()->json($results);
  }

  public function list_count()
  {
    $results = Lists::where('status', 1)->count();
    return response()->json($results);
  }

  public function last_queue()
  {
    $result = Lists::orderby('id', 'desc')->limit(1)->get();
    return response()->json($result);
  }
  
  public function edit($id_service_box = 1, $id_staff = 1)
  {
    $lists = Lists::where('status', 1)->orderby('id', 'asc')->limit(1)->get();
    if ($lists != '[]') {
      $value = Temp::where('id_service_box', $id_service_box)->get();
      if ($value == '[]') {
        $value = $this->create_temp($lists, $id_service_box);
      }
      else {
        $value = Temp::where('id_service_box', $id_service_box)->get();
        if ($lists != '[]') {
          Temp::where('id_service_box', $id_service_box)->delete();
        }
        $results = Lists::find($value['0']['id_list']);
        if ($results->end_time == '0000-00-00 00:00:00') {
          $results->end_time = date("Y-m-d H:i:s");
          $results->save();
        }
        $value = $this->create_temp($lists, $id_service_box);
      }
      $results = Lists::find($value->id_list);
      $results->id_service_box = $id_service_box;
      $results->id_staff = $id_staff;
      $results->call_time = date("Y-m-d H:i:s");
      $results->status = 0;
      $results->save();
    }
    return response()->json($this->response);
  }

  public function create()
  {
    $result = Lists::orderby('id', 'desc')->limit(1)->get();
    if ($result == '[]') {
      $queue = 1;
    }
    else {
      $queue = $result['0']['queue']+1;
    }
    $result = new Lists;
    $result->queue = $queue;
    $result->status = 1;
    $result->create_time = date("Y-m-d H:i:s");
    $result->save();
    return response()->json($this->response); 
  }

  public function temp()
  {
    $lists = Temp::orderby('id', 'desc')->get();
    return response()->json($lists);
  }

  public function find_temp($id)
  {
    $result = Temp::where('id_service_box', $id)->get();
    $result = Lists::find($result['0']['id_list']);
    $result['call_time'] = date("H:i:s", strtotime($result['call_time']));
    // foreach ($result as $key => $value) {
    //     $result[$key]['call_time'] = ;
    // }
    return response()->json($result);
  }

  private function create_temp($lists, $id_service_box)
  {
    $temp = new Temp;
    $temp->id_list = $lists['0']['id'];
    $temp->queue = $lists['0']['queue'];
    $temp->id_service_box = $id_service_box;
    $temp->save();
    return $temp;
  }
  
  public function last_temp()
  {
    $lists = Temp::orderby('id', 'desc')->limit(1)->get();
    return response()->json($lists);
  }
  
  public function left_queue($queue)
  {
    $lists  = Lists::where('status', 1)->select('queue')->get();
    $left = 0;
    foreach ($lists as $value) {
      if ($value['queue'] != $queue) {
        $left = $left + 1;
      }else{
        break;
      }
    }
    return response()->json($left);
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