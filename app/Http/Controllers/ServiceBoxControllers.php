<?php
namespace App\Http\Controllers;

use App\Models\ServiceBox;

use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class ServiceBoxControllers extends BaseController {
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
  
  public function get()
  {  
      $results = ServiceBox::all();
      return response()->json($results);
  }
  public function get_by_id($id)
  {
      $results = ServiceBox::find($id);
      return response()->json($results);
  }
  public function create(Request $request)
  {
    $result = new ServiceBox;
    $result->name = $request->name;
    $result->status = 1;
    $result->save();
    return response()->json($this->response); 
  }
  public function edit(Request $request)
  {
    $results = ServiceBox::find($request->id);
    $results->name = $request->name;
    $results->status = 1;
    $results->save();
    return response()->json($this->response);
  }
  public function status_using(Request $request)
  {
    $results = ServiceBox::find($request->id);
    $results->status = $request->status;
    $results->save();
    return response()->json($this->response);
  }
  
}