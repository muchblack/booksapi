<?php

namespace App\Http\Controllers;

use App\Http\Services\UserService;
use App\Models\Users;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        //
        return response()->json(['users' => $this->userService->getAllUsers()]);
    }
}
