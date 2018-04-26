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
        $value = Temp::where('id_service_box', $request->idServiceBox)->get();
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
    public function get_count_queue_in_hour()
    {        
      $result = Lists::all();
      $result16=[];
      $result9=[];
      $result10=[];
      $result11=[];
      $result12=[];
      $result13=[];
      $result14=[];
      $result15=[];
      $result16=[];
      $result17=[];
      foreach($result as $key=>$value)
      { 
         $time=date("H", strtotime($value['call_time']));
          if($time=='01'){$time=$time+7;$result8[$key]['time_08']=$time;}
          else if($time=='02'){$time=$time+7;$result9[$key]['time_09']=$time;}
          else if($time=='03'){$time=$time+7;$result10[$key]['time_10']=$time;}
          else if($time=='04'){$time=$time+7;$result11[$key]['time_11']=$time;}
          else if($time=='05'){$time=$time+7;$result12[$key]['time_12']=$time;}
          else if($time=='06'){$time=$time+7;$result13[$key]['time_13']=$time;}
          else if($time=='07'){$time=$time+7;$result14[$key]['time_14']=$time;}
          else if($time=='08'){$time=$time+7;$result15[$key]['time_15']=$time;}
          else if($time=='09'){$time=$time+7;$result16[$key]['time_16']=$time;}
          else if($time=='10'){$time=$time+7;$result17[$key]['time_17']=$time;}
          // }    
      }
      $count_time['time_08']=count($result8);
      $count_time['time_09']=count($result9);
      $count_time['time_10']=count($result10);
      $count_time['time_11']=count($result11);
      $count_time['time_12']=count($result12);
      $count_time['time_13']=count($result13);
      $count_time['time_14']=count($result14);
      $count_time['time_15']=count($result15);
      $count_time['time_16']=count($result16);
      $count_time['time_17']=count($result17);

      return response()->json($count_time);
    }
    public function get_count_queue_day_in_month()
    {
        $result = Lists::all();
        $current_month=(date('m'));
        $result1=[];
        $result2=[];
        $result3=[];
        $result4=[];
        $result5=[];
        $result6=[];
        $result7=[];
        $result8=[];
        $result9=[];
        $result10=[];
        $result11=[];
        $result12=[];
        $result13=[];
        $result14=[];
        $result15=[];
        $result16=[];
        $result17=[];
        $result18=[];
        $result19=[];
        $result20=[];
        $result21=[];
        $result22=[];
        $result23=[];
        $result24=[];
        $result25=[];
        $result26=[];
        $result27=[];
        $result28=[];
        $result29=[];
        $result30=[];
        $result31=[];
        foreach($result as $key=>$value)
        {
        if($current_month==date("m", strtotime($value['call_time'])) )
          {
            if(date("d", strtotime($value['call_time']))=='01'){$result1[$key]['day_01']="n";}
            if(date("d", strtotime($value['call_time']))=='02'){$result2[$key]['day_02']="n";}
            if(date("d", strtotime($value['call_time']))=='03'){$result3[$key]['day_03']="n";}
            if(date("d", strtotime($value['call_time']))=='04'){$result4[$key]['day_04']="n";}
            if(date("d", strtotime($value['call_time']))=='05'){$result5[$key]['day_05']="n";}
            if(date("d", strtotime($value['call_time']))=='06'){$result6[$key]['day_06']="n";}
            if(date("d", strtotime($value['call_time']))=='07'){$result7[$key]['day_07']="n";}
            if(date("d", strtotime($value['call_time']))=='08'){$result8[$key]['day_08']="n";}
            if(date("d", strtotime($value['call_time']))=='09'){$result9[$key]['day_09']="n";}
            if(date("d", strtotime($value['call_time']))=='10'){$result10[$key]['day_10']="n";}
            if(date("d", strtotime($value['call_time']))=='11'){$result11[$key]['day_11']="n";}
            if(date("d", strtotime($value['call_time']))=='12'){$result12[$key]['day_12']="n";}
            if(date("d", strtotime($value['call_time']))=='13'){$result13[$key]['day_13']="n";}
            if(date("d", strtotime($value['call_time']))=='14'){$result14[$key]['day_14']="n";}
            if(date("d", strtotime($value['call_time']))=='15'){$result15[$key]['day_15']="n";}
            if(date("d", strtotime($value['call_time']))=='16'){$result16[$key]['day_16']="n";}
            if(date("d", strtotime($value['call_time']))=='17'){$result17[$key]['day_17']="n";}
            if(date("d", strtotime($value['call_time']))=='18'){$result18[$key]['day_18']="n";}
            if(date("d", strtotime($value['call_time']))=='19'){$result19[$key]['day_19']="n";}
            if(date("d", strtotime($value['call_time']))=='20'){$result20[$key]['day_20']="n";}
            if(date("d", strtotime($value['call_time']))=='21'){$result21[$key]['day_21']="n";}
            if(date("d", strtotime($value['call_time']))=='22'){$result22[$key]['day_22']="n";}
            if(date("d", strtotime($value['call_time']))=='23'){$result23[$key]['day_23']="n";}
            if(date("d", strtotime($value['call_time']))=='24'){$result24[$key]['day_24']="n";}
            if(date("d", strtotime($value['call_time']))=='25'){$result25[$key]['day_25']="n";}
            if(date("d", strtotime($value['call_time']))=='26'){$result26[$key]['day_26']="n";}
            if(date("d", strtotime($value['call_time']))=='27'){$result27[$key]['day_27']="n";}
            if(date("d", strtotime($value['call_time']))=='28'){$result28[$key]['day_28']="n";}
            if(date("d", strtotime($value['call_time']))=='29'){$result29[$key]['day_29']="n";}
            if(date("d", strtotime($value['call_time']))=='30'){$result30[$key]['day_30']="n";}
            if(date("d", strtotime($value['call_time']))=='30'){$result31[$key]['day_31']="n";}
            
          }  
        }
        $count_time['day_01']=count($result1);
        $count_time['day_02']=count($result2);
        $count_time['day_03']=count($result3);
        $count_time['day_04']=count($result4);
        $count_time['day_05']=count($result5);
        $count_time['day_06']=count($result6);
        $count_time['day_07']=count($result7);
        $count_time['day_08']=count($result8);
        $count_time['day_09']=count($result9);
        $count_time['day_10']=count($result10);

        $count_time['day_11']=count($result11);
        $count_time['day_12']=count($result12);
        $count_time['day_13']=count($result13);
        $count_time['day_14']=count($result14);
        $count_time['day_15']=count($result15);
        $count_time['day_16']=count($result16);
        $count_time['day_17']=count($result17);
        $count_time['day_18']=count($result18);
        $count_time['day_19']=count($result19);
        $count_time['day_20']=count($result20);

        $count_time['day_21']=count($result21);
        $count_time['day_22']=count($result22);
        $count_time['day_23']=count($result23);
        $count_time['day_24']=count($result24);
        $count_time['day_25']=count($result25);
        $count_time['day_26']=count($result26);
        $count_time['day_27']=count($result27);
        $count_time['day_28']=count($result28);
        $count_time['day_29']=count($result29);
        $count_time['day_30']=count($result30);
        $count_time['day_31']=count($result31);
    
          // $count_date[date("d", strtotime($value['call_time']))]=count($result2);
   
          
      return response()->json($count_time);
    }
}