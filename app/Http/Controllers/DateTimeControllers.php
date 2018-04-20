<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laravel\Lumen\Routing\Controller as BaseController;

class DateTimeControllers extends BaseController
{

  public function date()
  {
    $results = date("Y/m/d");
    return response()->json($results);
  }

  public function time()
  {
    $results = date("H:i:s");
    return response()->json($results);
  }

}
