<?php

namespace App\Http\Controllers;

use App\Http\Services\BooksService;
use App\Http\Services\UserService;
use App\Models\Books;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    public function __construct(BooksService $bookService, UserService $userService){
        $this->bookService = $bookService;
        $this->userService = $userService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        //
        $size = $request->get('size', 20);
        $data = $this->bookService->getAllBooks($size);
        return response()->json([
            'data'=> $data['data'],
            'total'=> $data['total'],
            'per_page'=> $data['per_page'],
            'current_page'=> $data['current_page'],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        //
        $user = $this->userService->getUserFromApiToken($request->header('Authorization'));
        $result = $this->bookService->storeBooks($request->post(), $user);
        if($result['status'] === 0 )
        {
            return response()->json(['msg'=>$result['msg']], 201);
        }
        else
        {
            return response()->json(['msg'=> 'Invalid book data'], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id): \Illuminate\Http\JsonResponse
    {
        //
        $book = $this->bookService->getBook($id);
        return response()->json(['data' => $book]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request)
    {
        //
        $user = $this->userService->getUserFromApiToken($request->header('Authorization'));
        $result = $this->bookService->updateBook($id, $user->id);

        if($result['status'] === 0 )
        {
            return response()->json(['msg'=>'The book was updated successfully'], 200);
        }
        else
        {
            return response()->json(['msg'=> $result['msg']], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, Request $request): \Illuminate\Http\JsonResponse
    {
        //
        $user = $this->userService->getUserFromApiToken($request->header('Authorization'));
        $result = $this->bookService->delBook($id, $user->id);
        if($result['status'] === 0 )
        {
            return response()->json(['msg'=>'The book was deleted successfully'], 204);
        }
        else
        {
            return response()->json(['msg'=>'The book does not exist'], 404);
        }
    }
}
