<?php

namespace App\Http\Services;

use App\Models\BookImgs;
use App\Models\Books;
use App\Traits\BookEditLogging;

class BooksService
{
    use BookEditLogging;
    public function __construct(Books $books, BookImgs $bookImgs){
        $this->books = $books;
        $this->bookImgs = $bookImgs;
    }

    public function getAllBooks($size)
    {
        $data = $this->books->paginate($size);
        foreach($data as &$book){
            $book->images = $book->bookImgs ?? [];
            unset($book->bookImgs);
        }
        return $data->toArray();
    }

    public function getBook($id)
    {
        $book = $this->books->find($id);
        $book->images = $book->bookImgs ?? [];
        unset($book->bookImgs);

        return $book;
    }

    public function updateBook($id, $userId, $data)
    {
        $book = $this->books->where('id', $id)->where('bookAdder', $userId)->first();
        if($book){
            $this->bookImgs->where('book_id', $id)->delete();

            $book->titla = $data['title'];
            $book->author = $data['author'];
            $book->publicDate = $data['publicDate'];
            $book->category = $data['category'];
            $book->price = $data['price'];
            $book->quantity = $data['quantity'];
            $book->save();

            foreach($data['images'] as $image)
            {
                $this->bookImgs->create([
                    'book_id' => $id,
                    'name'=> $image['name'],
                    'path' => $image['path'],
                ]);
            }

            return ['status'=> 0 ];
        }
        else
        {
            return ['status' => 1, ['msg' => 'The book does not exist']];
        }
    }

    public function storeBooks($data, $user)
    {
        $book = $this->books->where('title', $data['title'])->first();
        if($book)
        {
            return ['status' => 1, 'msg' => 'book already exists'];
        }
        else
        {
            $newBook = $this->books->create(
                [
                    'title' => $data['title'],
                    'author' => $data['author'],
                    'bookAdder' => $user->id,
                    'publicDate' => $data['publicDate'],
                    'category' => $data['category'],
                    'price' => $data['price'],
                    'quantity' => $data['quantity'],
                ]
            );

            foreach($data['images'] as $image)
            {
                $this->bookImgs->create([
                    'book_id' => $newBook->id,
                    'name'=> $image['name'],
                    'path' => $image['path'],
                ]);
            }


            $this->logAction($user->id, 'add');

            if($newBook)
            {
                return ['status' => 0, 'msg' => 'The book was created successfully'];
            }
            else
            {
                return ['status' => 1, 'msg' => 'DB ERROR'];
            }

        }
    }

    public function delBook($id, $userId)
    {
        $book = $this->books->where('id', $id)->where('bookAdder', $userId)->first();
        if($book)
        {
            $this->books->destroy($id);
            return ['status' => 0];
        }
        else
        {
            return ['status' => 1];
        }
    }
}
