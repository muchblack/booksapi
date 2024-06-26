<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BooksResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
//        return parent::toArray($request);
        return [
            'id' => $this->id,
            'title' => $this->title,
            'author' => $this->author,
            'bookAdder' => $this->bookAdder,
            'publicDate' => $this->publicDate,
            'category' => $this->category,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'images' => $this->bookImgs,
        ];
    }
}
