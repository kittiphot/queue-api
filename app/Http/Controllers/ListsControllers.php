<?php
namespace App\Http\Controllers;

use App\Models\Lists;
use App\Models\Temp;
use App\Models\config;
use App\Models\ServiceBox;

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

  public function count_todo_queue_in_list()
  {
    $results = Lists::where('status',1)->count();
    $result['count']=$results;
    return response()->json($result);
  }

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
  
  public function edit(Request $request)
  {
    $lists = Lists::where('status', 1)->orderby('id', 'asc')->limit(1)->get();
    if ($lists != '[]') {
      $value = Temp::where('id_service_box', $request->idServiceBox)->get();
      if ($value == '[]') {
        $value = $this->create_temp($lists, $request->idServiceBox);
      }
      else {
        // $value = Temp::where('id_service_box', $request->idServiceBox)->get();
        if ($lists != '[]') {
          Temp::where('id_service_box', $request->idServiceBox)->delete();
        }
        $results = Lists::find($value['0']['id_list']);
        if ($results->end_time == '0000-00-00 00:00:00') {
          $results->end_time = date("Y-m-d H:i:s");
          $results->save();
        }
        $value = $this->create_temp($lists, $request->idServiceBox);
      }
      $results = Lists::find($value->id_list);
      $results->id_service_box = $request->idServiceBox;
      $results->id_staff = $request->idStaff;
      $results->call_time = date("Y-m-d H:i:s");
      $results->status = 0;
      $results->save();
      $this->response['message'] = "call";
      $this->response['queue'] = $results->queue;
    }
    return response()->json($this->response);
  }

  public function create()
  {
    $results = config::find(2);
    $queue = $results['value']+1;
    $results->value = $queue;
    $results->save();
    $result = new Lists;
    $result->queue = $queue;
    $result->status = 1;
    $result->create_time = date("Y-m-d H:i:s");
    $result->save();
    return response()->json($this->response); 
  }

  public function temp()
  {
    $results = Temp::orderby('id', 'desc')->get();
    foreach ($results as $key => $value) {
      $result = ServiceBox::find($value['id_service_box']);
      $results[$key]['name'] = $result['name'];
    }
    // $lists = ServiceBox::find($lists['0']['id_service_box']);
    return response()->json($results);
  }

  public function find_temp($id)
  {
    $result = Temp::where('id_service_box', $id)->get();
    if ($result == '[]') {
      $result['queue'] = "";
      $result['call_time'] = "";
      return response()->json($result);
    }
    $result = Lists::find($result['0']['id_list']);
    $result['call_time'] = date("H:i:s", strtotime($result['call_time']));
    return response()->json($result);
  }

  public function repeat_temp($id)
  {
    $result = Temp::where('id_service_box', $id)->get();
    Temp::where('id_service_box', $id)->delete();
    $results = new Temp;
    $results->id_list = $result['0']['id_list'];
    $results->queue = $result['0']['queue'];
    $results->id_service_box = $id;
    $results->save();
    $results = Lists::find($results->id_list);
    $results->call_time = date("Y-m-d H:i:s");
    $results->save();
    // return response()->json($results);
    $this->response['message'] = "repeat";
    $this->response['queue'] = $results->queue;
    return response()->json($this->response);
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
    public function get_all_list_queue_today()
    {
      $result = Lists::all();

      foreach($result as $key=>$value)
      {      
         $current_date=(date('Y-m-d'));
        //  $current_date=$request->create_time;
          if($current_date==date("Y-m-d", strtotime($value['create_time'])) )
          {
              $result2[$key]['mo']='m';
          }    
      }
      $count_date['count_list_today']=count($result2);

      return response()->json($count_date);
    }
}