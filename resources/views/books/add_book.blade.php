<form method="post" action="/books" class="form-group text-center" enctype="multipart/form-data">
	{{csrf_field()}}
	<div class="container col-12 text-center" style="border: 5px solid black; padding: 10px;">
		ISBN: <input class="form-control" type="number" name="isbn"><br>
		Title: <input  class="form-control"type="text" name="name"><br>
		Description: <input  class="form-control"type="text" name="description"><br>
		Stock: <input  class="form-control"type="number" min="0" name="stock"><br>
		Category: 
		<select class="form-control" name="category_id">
			@foreach($categories as $category)
			@if ($category->name != 'Uncategorized')
				<option value="{{$category->id}}">{{$category->name}}</option>
			@endif
			@endforeach
		</select>
		<br>
		Image: <input src="/assets/image" type="file" name="image"><br>
		<br>
		<button class="btn btn-warning" id="addModalBtn">Add Book</button>
	</div>
</form>


