<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Book;
use App\Status;
use App\User;
use Session;
use Auth;

class BookRequestController extends Controller
{

    public function index() {

      $requests = Book::whereHas('users', function ($query){
          $query->where('book_user.status', 0);
        })->get();
      return view('books.admin_page', compact('requests'));
    }

    // SHOW ADMIN PAGE
    //----------------------------------------------------------------------
    public function create($id) {
      $user = Auth::user();
    	$book = Book::find($id);

    	return view('books.borrow_form', compact('book', 'user'));
    }
    //END OF SHOW ADMIN PAGE

    public function borrow(Request $request) {
      $id = $request->book_id;
      $borrower = $request->user_id;
      $qty = $request->qty;
      $user = Auth::user();
      $book = Book::find($id);
      $filter = $user->books()->wherePivot('book_id', '=', $id)->wherePivot('status', '=', 0)->first();

      if ($filter != null) {
        $qty += $filter->pivot->quantity;
        $user->books()->updateExistingPivot($id, ['quantity' => $qty]);
      } else
        $user->books()->attach($id, ['quantity' => $qty]);

      Session::flash('borrow', 'Borrow request sent. Please wait for approval.');
      return redirect()->back();
    }

    // APPROVE/DECLINE/RETURN BOOK REQUESTS
    //----------------------------------------------------------------------
    public function approve($id, $bid, $qty){
      $user = User::find($id);
      $book = Book::find($bid);
      $book->users()->updateExistingPivot($id, ['status' => 1]);
      $book->stock -= $qty;
      $book->save();

      Session::flash('approve', 'Book request has been approved.');
      return redirect()->back();
    }

    public function decline($id, $bid){
      $user = User::find($id);
      $user->books()->detach($bid);

      Session::flash('declined', 'Book request has been denied.');
      return redirect()->back();
    }

    public function returnbooks(){
      $requests = Book::whereHas('users', function ($query){
          $query->where('book_user.status', 1);
        })->get();

      return view('books.return_books', compact('requests'));
    }

    public function return($id, $bid, $bookuser, $qty){
      $user = User::find($id);
      $book = Book::find($bid);
      $book->users()->wherePivot('id', '=', $bookuser)->detach($id);

      $book->stock += $qty;
      $book->save();

      Session::flash('returned', 'Book/s returned.');
      return redirect()->back();
    }
    //END OF APPROVE/DECLINE/RETURN BOOK REQUESTS
}
