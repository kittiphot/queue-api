<?php
namespace App\Http\Controllers;
use App\Models\config;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

namespace App\Http\Controllers;

class ConfigControllers extends Controller
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

  
  public function edit(Request $request) 
  {
    $results = config::find($request->id);
    $results->caption = $request->caption;
    $results->save();
    return response()->json($this->response);
  }
  
  


}
