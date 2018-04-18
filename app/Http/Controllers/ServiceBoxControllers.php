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
  


  public function create(Request $request)
  {
    $result = new ServiceBox;
    $result->name = $request->name;
    $result->status = 1;
    $result->save();
    return response()->json($this->response); 
  }
  
}