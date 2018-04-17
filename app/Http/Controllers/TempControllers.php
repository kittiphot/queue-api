<?php
namespace App\Http\Controllers;

use App\Models\Temp;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class TempControllers extends BaseController {
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
  
  public function find()
  {
    $results = Temp::find($request->id);
    $result->save();
    return response()->json($result);
  }

}