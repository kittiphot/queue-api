<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\config;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laravel\Lumen\Routing\Controller as BaseController;

class ConfigControllers extends Controller
{
    private $response = array('status' => 1, 'message' => 'success');
    public function Config()
    {
        $results = config::all();
        return response()->json($results);
    }

    public function create(Request $request)
    {
        $results = new config;
        $results ->id = $request->id;
        $results ->name = $request->name;
        $results ->value = $request->value;
        $results ->save();
        return response()->json($this->response); 
    }

    public function edit(Request $request) 
    {
<<<<<<< HEAD:app/Http/Controllers/ConfigControllers.php
        $results = config::find($request->id);
        $results ->name = $request->name;
        $results ->value = $request->value;
        $results ->status = $request->status;
        $results->save();
        return response()->json($this->response);
    }

    public function resetQueue()
    {
        $results = config::find(2);
        $results ->value = 0;
        $results->save();
        return response()->json($this->response);
    }

    public function editQueueFormat(Request $request)
    {
        $results = config::find(1);
        $results ->value = $request->queueFormat;
        $results->save();
=======
        // $results = config::find($request->id);
        // $results ->name = $request->name;
        // $results ->value = $request->value;
        // $results->save();
        // return response()->json($this->response);
        $results = config::where('id', 1)->get();
        $data = config::find($results['0']['id']);
        $data ->value = $request->format;
        $data->save();

        $results = config::where('id',2)->get();
        $data = config::find($results['0']['id']);
        $data ->value = $request->reset;
        $data->save();
>>>>>>> 5d327ecea7451e881b6f21625b1d823587416ae8:app/Http/Controllers/getConfigControllers.php
        return response()->json($this->response);
    }

}