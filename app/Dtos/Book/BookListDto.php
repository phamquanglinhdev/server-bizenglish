<?php

namespace App\Dtos\Book;

use App\Models\Book;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class BookListDto
{
    public function __construct(
        private readonly Book|Model|Builder $book
    )
    {
    }

    public function toArray(): array
    {
        return [
            'name' => $this->book["name"],
            'thumbnail' => $this->book["thumbnail"],
            'link' => $this->book["link"],
        ];
    }
}
