<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Services\UserService;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function __construct(UserService $service){
        $this->service = $service;
    }

    public function login(Request $request): \Illuminate\Http\JsonResponse
    {
        $result = $this->service->getLogin($request->post());
        if($result['status'] !== 0 )
        {
            return response()->json(['msg' => $result['msg']], 404);
        }
        else
        {
            return response()->json(['token' => $result['token']], 200);
        }
    }

    public function register(Request $request): \Illuminate\Http\JsonResponse
    {
        $result = $this->service->setRegister($request->post());

        $statusCode = 200;
        if($result['status'] !== 0 )
        {
            $statusCode = 400;
        }

        return response()->json(['msg' => $result['msg']], $statusCode);
    }
}
