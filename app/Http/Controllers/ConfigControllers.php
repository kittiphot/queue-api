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
        return response()->json($this->response);
    }

    public function settings()
    {   
        $results = config::where([
            ['id', '>=', 3],
            ['id', '<=', 6]        
        ])->get();
        return response()->json($results);
    }

    public function settings_by_status()
    {   
        $results = config::where([
            ['status', 1],
            ['id', '>=', 3],
            ['id', '<=', 6]
        ])->get();
        return response()->json($results);
    }

    public function edit_settings(Request $request)
    {   
        $result = config::find(3);
        $result->status = $request->statusLogo;
        $result->save();
        $result = config::find(4);
        $result->status = $request->statusQR;
        $result->save();
        $result = config::find(5);
        $result->status = $request->statusWait;
        $result->save();
        $result = config::find(6);
        $result->value = $request->footerInput;
        $result->status = $request->statusFooter;
        $result->save();
        return response()->json($this->response);
    }

    public function userScreen()
    {   
        $result = config::find(7);
        return response()->json($result);
    }

    public function screen()
    {   
        $result = config::find(8);
        return response()->json($result);
    }

    public function edit_Screen(Request $request)
    {   
        $result = config::find(7);
        $result->value = $request->userScreen;
        $result->save();
        $result = config::find(8);
        $result->value = $request->pushQueueScreen;
        $result->save();
        return response()->json($this->response);
    }

}