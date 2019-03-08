<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Book;
use App\Status;
use Session;
use Auth;

class BookController extends Controller
{
    public function index(Request $request){
        $user = Auth::user();
    	if ($request->has('search'))
    		$books = Book::where('name', 'like', '%'.$request->search.'%')->get(); 
        else $books = Book::all();

        return view('books.book_list', compact('books', 'user'));
        }

    // ADD BOOKS
    //----------------------------------------------------------------------    
        public function create() {
        	$categories = Category::all();

        	return view('books.add_book', compact('categories'));
        }

        public function store(Request $request) {
        	$books = Book::all();
    			$new_book = new Book();
                $new_book->isbn = $request->isbn;
    			$new_book->name = $request->name;
    			$new_book->stock = $request->stock;
    			$new_book->description = $request->description;
    			$new_book->category_id= $request->category_id;

    			// Save image
    			$request->image->move('assets/images/', $request->image->getClientOriginalName());
    			// Get image
    			$new_book->image = '../assets/images/'.$request->image->getClientOriginalName();

    			$new_book->save();

    			Session::flash('add', "$new_book->name added successfully.");
    			return redirect('/books');
            } 
    //END OF ADD BOOKS

    //SHOW DETAILS
    //----------------------------------------------------------------------
        public function show($id) {
            $books = Book::find($id);
            $categories = Category::all();
            return view('books.show_book', compact('books', 'categories'));
        } 
    //END OF SHOW DETAILS

    //EDIT BOOK
    //----------------------------------------------------------------------
        public function edit($id) {
            $books = Book::find($id);
            $categories = Category::all();
            return view('books.edit_book', compact('books', 'categories'));
        } 

        public function update($id, Request $request) {
            $request->hasFile('image');
            $update_book = Book::find($id);
            $update_book->isbn = $request->isbn;
            $update_book->name = $request->name;
            $update_book->description = $request->description;
            $update_book->stock = $request->stock;
            $update_book->category_id= $request->category_id;
            if($request->hasFile('image') == true){
                    $request->image->move('assets/images/', $request->image->getClientOriginalName());
                // Get image
                    $update_book->image = '../assets/images/'.$request->image->getClientOriginalName();

                    $update_book->save();
                } else $update_book->save();

            Session::flash('editBook', "$update_book->name has been edited successfully.");
            return redirect()->back();
        } 
    // END OF EDIT BOOK

    // DELETE BOOK
    //----------------------------------------------------------------------
        public function destroy($id) {
            $book = Book::find($id);
            $book->delete();

            Session::flash('deleteBook', "$book->name has been deleted successfully.");
        }
    // END OF DELETE BOOK

    //CUSTOMER REQUESTS
        public function customerPage() {
            $user = Auth::user();

          return view('books.customer_requests', compact('user'));
        }
}


    //END OF CUSTOMER REQUEST

