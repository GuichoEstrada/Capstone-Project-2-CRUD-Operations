@extends('partials.template')

@section('title', 'Categories')

@section('content')
@if (Session::has('addCat'))
	<div class="alert alert-success">
		{{Session::get('addCat')}}
	</div>
@endif
@if (Session::has('editCat'))
	<div class="alert alert-warning">
		{{Session::get('editCat')}}
	</div>
@endif
@if (Session::has('deleteCat'))
	<div class="alert alert-danger">
		{{Session::get('deleteCat')}}
	</div>
@endif

<h1 class="text-center mt-3" align="center"><i class="fas fa-list"> Categories</i></h1>
<div class="col-12 text-center mt-3">
	<button class="btn btn-secondary mb-3" id="addCat" data-toggle="modal" data-target="#addCatModal"><i class="far fa-plus-square"></i> Add Category</button>
</div>

<table class="table table-striped text-center mb-5" id="categoryList" style="font-size: 24px; font-weight: bold; ">
	<thead>
		<tr>
			<td><strong><i class="fas fa-list"></i> Category</strong></td>
			<td></td>
			<td></td>
		</tr>
	</thead>
	<tbody class="text-center">
		@foreach($categories as $category)
		@if ($category->name != 'Uncategorized')
			<tr id="row{{$category->id}}" style="border: 5px solid black;">
				<td class="align-middle">{{$category->name}}</td>
				<td class="align-middle" data-id="{{$category->id}}" data-name="{{$category->name}}">
					<button class="btn btn-warning editCatBtn" data-toggle="modal" data-target="#editModal"><i class="fas fa-edit"></i> Edit</button>
				</td>
				<td class="align-middle" data-id="{{$category->id}}" data-name="{{$category->name}}">
					<button class="btn btn-danger delBtn" data-toggle="modal" data-target="#deleteCatModal"><i class="fas fa-trash-alt"></i> Delete</button>
				</td>
			</tr>
		@endif
		@endforeach
	</tbody>
</table>

{{-- EDIT CATEGORY NAME MODAL --}}
<div class="modal" tabindex="-1" id="addCatModal" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addCategoryName"><strong>Add Category</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="addCatModalBody">
        <p></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div> {{--END OF ADD CATEGORY NAME MODAL --}}

{{-- EDIT CATEGORY NAME MODAL --}}
<div class="modal" tabindex="-1" id="editModal" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editCategoryName"><strong>Edit Category Name</strong></h5>
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
</div> {{--END OF EDIT CATEGORY NAME MODAL --}}

{{-- DELETE CATEGORY MODAL --}}
<div class="modal" tabindex="-1" id="deleteCatModal" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteCatName"><strong></strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete this category?</p>
      </div>
      <div class="modal-footer">
        <button  id="deleteModalBtn" type="button" data-dismiss="modal" class="btn btn-danger">Delete</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>{{--END OF DELETE CATEGORY MODAL --}}

<script type="text/javascript">
	const csrfToken =document.querySelector('meta[name="csrf-token"]').getAttribute('content');

	addCat.addEventListener('click', function(){
		fetch('/categories/add_category')
		.then( function(res) {
			return res.text();
		})
		.then( function(data){
			addCatModalBody.innerHTML = data
		})
	})

	categoryList.addEventListener('click', function(e){ 
	if (e.target.classList.contains('editCatBtn')) {
			let id = e.target.parentElement.getAttribute('data-id');
			let name = e.target.parentElement.getAttribute('data-name');
			let data = new FormData;

			data.append('_token', csrfToken);

			fetch('/categories/'+id+'/edit')
			.then( function(res) {
				return res.text();
			})
			.then( function(data){
				editModalBody.innerHTML = data
			})
		} else {
			let id = e.target.parentElement.getAttribute('data-id');
			let name = e.target.parentElement.getAttribute('data-name');
			deleteCatName.innerHTML = "<strong>" + name + "</strong>";
			deleteModalBtn.setAttribute('data-id', id);
			deleteModalBtn.setAttribute('data-name', name);
		}

		deleteModalBtn.addEventListener('click', function(){
			let id = deleteModalBtn.getAttribute('data-id');
			let name = deleteModalBtn.getAttribute('data-name');
			let data = new FormData;
				
			data.append('_method', 'DELETE');
			data.append('_token', csrfToken);

			fetch ('/categories/'+id, {
				method: 'post',
				body: data
			})
			.then( function(res) {
				return res.text();
			}).then( function(data){
				document.querySelector('#row'+id).remove();
			});
		})
	});
</script>

@endsection