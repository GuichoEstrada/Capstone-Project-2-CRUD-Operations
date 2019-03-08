<div class="card mb-3" style="max-width: 540px;">
  <div class="row no-gutters">
    <div class="col-md-8">
      <img src="{{$book->image}}" width="100%" align="center">
    </div>
    <div class="col-md-4">
      <div class="card-body text-center" style="border: 5px solid black; padding: 10px;">
        <h5><strong>{{$user->name}}</strong></h5>
        <p class="card-text">
        	<form method="post" action="/bookrequest/borrow_form" class="form-group">
  				  {{csrf_field()}}
            <h5><strong>{{$book->name}}</strong></h5>
            Stock: <p>{{$book->stock}}</p>
  					Quantity: <input class="form-control" type="number" min="1" max="{{$book->stock}}" name="qty" id="bookQty" value="1"><br>
  					Current Date: {{date('Y-m-d H:i:s')}}
            <input type="hidden" name="book_id" value="{{$book->id}}">
            <button class="btn btn-primary mt-5">Borrow Book</button>
			    </form>
        </p>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  
</script>