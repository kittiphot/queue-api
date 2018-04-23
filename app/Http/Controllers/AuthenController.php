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

  private function get_person_profile($person_id)
  {
    $result = Person::find($person_id);
    return $result;
  }

}
