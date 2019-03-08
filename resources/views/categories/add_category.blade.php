<form method="post" action="/categories" class="form-group">
	{{csrf_field()}}
	<div class="container text-center" style="border: 5px solid black; padding: 20px;">
		Name: <input  class="form-control"type="text" name="name"><br>
		<button class="btn btn-success">Add Category</button>
	</div>
</form>
