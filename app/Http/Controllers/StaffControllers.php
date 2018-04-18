<?php

namespace App\Http\Controllers;

<<<<<<< HEAD
class StaffController extends Controller
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

    public function staff()
  {
    $results = staff::where('status', 1)->get();
    return response()->json($results);
  }

  public function create(Request $request)
  {
    $result = new staff;
    $result->caption = $request->caption;
    $result->save();
    return response()->json($this->response); 
  }
  
  public function edit(Request $request) 
  {
    $results = staff::find($request->id);
    $results->caption = $request->caption;
    $results->status = 1;
    $results->save();
    return response()->json($this->response);
  }
  
  public function delete($id) 
  {
    $results = staff::find($id);
    $results->status = 0;
    $results->save();
    return response()->json($this->response);
  }

    //
}
=======
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laravel\Lumen\Routing\Controller as BaseController;

class StaffControllers extends BaseController
{
    private $response = array('status' => 1, 'message' => 'success');

    public function staff()
    {
        $results = staff::where('status', 1)->get();
        return response()->json($results);
    }
    
    public function create(Request $request)
    {
        $results = new staff;
        $results ->name = $request->name;
        $results ->username = $request->username;
        $results ->password = $request->password;
        $results ->type = $request->type;
        $results ->status = $request->status;
        $results ->save();
        return response()->json($this->response); 
    }

    public function edit(Request $request) 
    {
        $results = staff::find($request->id);
        $results->name = $request->name;
        $results ->username = $request->username;
        $results ->password = $request->password;
        $results->type = $request->type;
        $results->status = $request->status;
        $results->save();
        return response()->json($this->response);
    }

    public function delete($id) 
    {
        $results = staff::find($id);
        $results->status = 0;
        $results->save();
        return response()->json($this->response);
    }
    
}
>>>>>>> b140da37ed6e40639146254dd722663fb7ab583b
