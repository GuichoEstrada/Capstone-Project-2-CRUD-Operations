<form method="post" action="/categories/{{$category->id}}" class="form-group">
	{{csrf_field()}}
	{{method_field('PUT')}}
	<div class="container col-8 text-center" style="border: 5px solid black; padding: 10px;">
			Name: <input class="form-control" type="text" name="name" value="{{$category->name}}"><br>
		<button class="btn btn-warning text-center mt-3 text-center">Edit Category Name</button>
	</div>
</form>