@extends('partials.template')

@section('title', 'Book List')

@section('content')

@if (Session::has('add'))
	<div class="alert alert-success">
		{{Session::get('add')}}
	</div>
@endif
@if (Session::has('editBook'))
	<div class="alert alert-warning">
		{{Session::get('editBook')}}
	</div>
@endif
@if (Session::has('deleteBook'))
	<div class="alert alert-danger">
		{{Session::get('deleteBook')}}
	</div>
@endif
@if (Session::has('borrow'))
	<div class="alert alert-success">
		{{Session::get('borrow')}}
	</div>
@endif

<div hidden class="alert alert-danger" id="delMessage">
</div>

<div class="container row text-center">
	<div class="container mt-3 text-center">
		<h4><i class="fas fa-search" aria-hidden="true"></i> Search:</h4>
		<form class="form-inline active-pink-3 active-pink-4" method="get" action="/books">
			{{csrf_field()}}
			<input class="form-control form-control-sm ml-3 w-75 col-12" placeholder="Search Book" aria-label="Search" type="text" name="search"><br>
		</form>
	</div>
</div>
<div class="container row text-center">
	<div class="row container text-center">
    	<h3 align="center"><i class="fas fa-book"></i> Books</h3>
    </div>
</div>
<table class="table table-striped text-center mb-5" id="bookList" style="font-size: 24px; font-weight: bold; ">
	<thead>
		<tr>
			<td><strong><i class="fas fa-images"></i> Image</strong></td>
			<td><strong><i class="fas fa-book-open"></i> Title</strong></td>
			<td><strong><i class="fas fa-sort-numeric-down"></i> Stock</strong></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
	</thead>
	<tbody class="text-center">
		@foreach($books as $book)
			<tr id="row{{$book->id}}" style="border: 5px solid black;">
				<td class="align-middle" style="border: 5px solid black;"><img src="/{{$book->image}}" width="120" height="120" style="border: 5px solid black;"></td>
				<td class="align-middle">{{$book->name}}</td>
				<td class="align-middle">{{$book->stock}}</td>
				<td class="align-middle" data-id="{{$book->id}}" data-name="{{$book->name}}">
					<button class="btn btn-primary detailBtn" data-toggle="modal" data-target="#detailsModal" style="box-shadow: 5px 3px #000000;"><i class="far fa-eye"></i> Show Details</button>
				</td>

				<td class="align-middle" data-id="{{$book->id}}" data-name="{{$book->name}}">
					@if(Auth::user() && Auth::user()->role_id == 2)
					@if($book->stock == 0)
					<button class="btn btn-secondary" style="box-shadow: 5px 3px #000000;"><i class="fas fa-minus-circle"></i> Out of Stock</button>
					@else
					<button class="btn btn-secondary borrowBtn" data-toggle="modal" data-target="#borrowModal" style="box-shadow: 5px 3px #000000;"><i class="fas fa-retweet"></i> Borrow Book</button>
					@endif
					@endif
				</td>

				<td class="align-middle" data-id="{{$book->id}}" data-name="{{$book->name}}">
					@if(Auth::user() && Auth::user()->role_id == 1)
					<button class="btn btn-warning editBtn" data-toggle="modal" data-target="#editModal" style="box-shadow: 5px 3px #000000;"><i class="fas fa-edit"></i> Edit</button>
					@endif
				</td>
				<td class="align-middle" data-id="{{$book->id}}" data-name="{{$book->name}}">
					@if(Auth::user() && Auth::user()->role_id == 1)
					<button class="btn btn-danger delBtn" data-toggle="modal" data-target="#deleteModal" style="box-shadow: 5px 3px #000000;"><i class="fas fa-trash-alt"></i> Delete</button>
					@endif
				</td>
			</tr>
		@endforeach
	</tbody>
</table>

{{-- SHOW DETAILS MODAL --}}
<div class="modal" tabindex="-1" id="detailsModal" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="showBookTitle"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="showDetails">
        <p></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
{{-- END OF SHOW DETAILS MODAL --}}

{{-- EDIT MODAL --}}
<div class="modal" tabindex="-1" id="editModal" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editItemName"><strong>Edit Book</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="editModalBody">
        <p></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div> {{--END OF EDIT MODAL --}}

{{-- DELETE MODAL --}}
<div class="modal" tabindex="-1" id="deleteModal" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteBookName"><strong></strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete this book?</p>
      </div>
      <div class="modal-footer">
        <button  id="deleteModalBtn" type="button" data-dismiss="modal" class="btn btn-danger">Delete</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>{{--END OF DELETE MODAL --}}

{{-- BORROW MODAL --}}
<div class="modal" tabindex="-1" id="borrowModal" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="borrowModalName"><strong>Borrow Form</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="borrowModalBody">
        <p></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div> {{--END OF BORROW MODAL --}}

{{-- JS FUNCTIONS --}}
<script type="text/javascript">
	const csrfToken =document.querySelector('meta[name="csrf-token"]').getAttribute('content');

	bookList.addEventListener('click', function(e){
		if (e.target.classList.contains('detailBtn')) {
			let id = e.target.parentElement.getAttribute('data-id');
			let name = e.target.parentElement.getAttribute('data-name');
			showBookTitle.innerHTML = "<strong>" + name + "</strong>";

			fetch('/books/'+id)
			.then( function(res) {
				return res.text();
			})
			.then( function(data){
				showDetails.innerHTML = data
			})

		} else if (e.target.classList.contains('editBtn')) {
			let id = e.target.parentElement.getAttribute('data-id');
			let name = e.target.parentElement.getAttribute('data-name');
			let data = new FormData;

			data.append('_token', csrfToken);

			fetch('/books/'+id+'/edit')
			.then( function(res) {
				return res.text();
			})
			.then( function(data){
				editModalBody.innerHTML = data
			})
			
		} else {
			let id = e.target.parentElement.getAttribute('data-id');
			let name = e.target.parentElement.getAttribute('data-name');
			deleteBookName.innerHTML = "<strong>" + name + "</strong>";
			deleteModalBtn.setAttribute('data-id', id);
			deleteModalBtn.setAttribute('data-name', name);
		}

		if  (e.target.classList.contains('borrowBtn')) {
			let id = e.target.parentElement.getAttribute('data-id');
			let name = e.target.parentElement.getAttribute('data-name');

			fetch('/bookrequest/'+id+'/borrow_form')
			.then( function(res) {
				return res.text();
			})
			.then( function(data){
				borrowModalBody.innerHTML = data
			})
		}
	})

			deleteModalBtn.addEventListener('click', function(){
			let id = deleteModalBtn.getAttribute('data-id');
			let name = deleteModalBtn.getAttribute('data-name');
			let data = new FormData;
				
			data.append('_method', 'DELETE');
			data.append('_token', csrfToken);

			fetch ('/books/'+id, {
				method: 'post',
				body: data
			})
			.then( function(res) {
				return res.text();
			}).then( function(data){
				document.querySelector('#row'+id).remove();
				delMessage.removeAttribute('hidden');
				delMessage.innerHTML = name + " has been deleted successfully.";
			});
		})


</script>

@endsection