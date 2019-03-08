<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Book;
use App\Status;
use Session;
use Auth;

class CategoryController extends Controller
{
    public function index() {
        $user = Auth::user();
    	$categories = Category::all();

    	return view('categories.categories_list', compact('categories', 'user'));
    }

    //ADD CATEGORY
    //----------------------------------------------------------------------
    public function create() {
    	$categories = Category::all();

    	return view('categories.add_category', compact('categories'));
    }


    public function store(Request $request) {
    	$categories = Category::all();
    	$new_category = new Category();
    	$new_category->name = $request->name;

    	$new_category->save();

    	Session::flash('addCat', "$new_category->name Category added successfully.");
    	return redirect('/categories');
    }

    //END OF ADD CATEGORY

    //EDIT CATEGORIES
    //----------------------------------------------------------------------
    public function edit($id) {
            $category = Category::find($id);
            return view('categories.edit_category', compact('category'));
        }

    public function update($id, Request $request) {
            $update_category = Category::find($id);
            $update_category->name = $request->name;
            $update_category->save();

            Session::flash('editCat', "$update_category->name Category has been edited successfully.");
            return redirect()->back();
        }
    //END OF EDIT CATEGORIES

    //DELETE CATEGORIES
    //----------------------------------------------------------------------
    public function destroy($id) {
    	$books = Category::find($id)->books;

    foreach ($books as $book) {
    	$book->category_id = 7;
    	$book->save();
    }

    	$category = Category::find($id);
    	$category->delete();
    	Session::flash('deleteCat', "$category->name Category has been deleted successfully.");
    }
    //END OF DELETE CATEGORIES  
}
