<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class AuthenController extends BaseController
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

  private $response = array('status' => 1, 'message' => 'success');

  public function authen(Request $request)
  {
    $username = $request->username;
    $password = $request->password;
    $result = Staff::where([
      ['username', $username],
      ['password', $password]
    ])->get();
    return response()->json($result);
  }

  public function logged(Request $request)
  {
    $result = Staff::find($request->id);
    $result->logged = $request->logged;
    $result->save();
    return response()->json($this->response); 
  }

}
