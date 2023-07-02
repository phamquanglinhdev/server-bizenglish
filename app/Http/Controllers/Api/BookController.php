<?php

namespace App\Http\Controllers\Api;

use App\Dtos\Book\BookListDto;
use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\User;
use App\Repositories\BookRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class BookController extends Controller
{

    public function __construct(
        private readonly BookRepository $bookRepository,
    )
    {
    }

    public function BookForHome(Request $request): array
    {
        /**
         * @var User $student
         */
        $student = $request->user();

        $bookForHome = [];
        $recommend = $this->bookRepository->getRecommendBook(6);
        $recommendDto = $recommend->map(function (Book $book) {
            return (new BookListDto(book: $book))->toArray();
        });
        $bookForHome["recommended"] = $recommendDto;
        //
        $trending = $this->bookRepository->getTrendingBooks(6);
        $trendingDto = $trending->map(function (Book $book) {
            return (new BookListDto(book: $book))->toArray();
        });
        $bookForHome["trending"] = $trendingDto;
        //Student
        $own = $this->bookRepository->getByStudent($student['id']);
        $ownDto = $own->map(function (Book $book) {
            return (new BookListDto(book: $book))->toArray();
        });
        $bookForHome['own'] = $ownDto;
        return $bookForHome;
    }
}
