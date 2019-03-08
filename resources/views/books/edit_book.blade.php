<div class="container text-center mb-3">
	<img src="{{$books->image}}" width="300" height="300" align="center">
</div>
<form method="post" action="/books/{{$books->id}}" class="form-group" enctype="multipart/form-data">
	{{csrf_field()}}
	{{method_field('PUT')}}
	<div class="container col-8 text-center" style="border: 5px solid black; padding: 10px;">
		ISBN: <input class="form-control" type="number" name="isbn" value="{{$books->isbn}}"><br>
		Name: <input class="form-control" type="text" name="name" value="{{$books->name}}"><br>
		Description: <input class="form-control" type="text" name="description" value="{{$books->description}}"><br>
		Stock: <input class="form-control" type="number" min="0" name="stock" value="{{$books->stock}}"><br>
		Category: 
		<select class="form-control" name="category_id">
			@foreach($categories as $category)
			@if ($category->name != 'Uncategorized')
				@if($books->category_id == $category->id)
					<option selected value="{{$category->id}}">{{$category->name}}</option>
				@else
					<option value="{{$category->id}}">{{$category->name}}</option>
				@endif
			@endif
			@endforeach
		</select><br>
		Image: <input class="form-control" src="/assets/image" type="file" name="image"><br>
		<button class="btn btn-warning text-center mt-3 text-center">Edit Book</button>
	</div>
</form>