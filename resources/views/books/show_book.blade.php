<div class="card mb-3" style="max-width: 540px;">
  <div class="row no-gutters">
    <div class="col-md-8">
      <img src="{{$books->image}}" width="100%" height="493" align="center">
    </div>
    <div class="col-md-4">
      <div class="card-body text-center" style="border: 5px solid black; padding: 10px;">
        <h5 class="card-title"><p><strong>{{$books->name}}</p></strong><br></h5>
        <p class="card-text">
        	ISBN: <p><strong>{{$books->isbn}}</p></strong><br>
    			Description: <p><strong>{{$books->description}}</p></strong><br>
    			Stock: <p><strong>{{$books->stock}}</p></strong><br>
    			Category: <div name="category_id">
    				@foreach($categories as $category)
    					@if($books->category_id == $category->id)
    						<p value="{{$category->id}}"><strong>{{$category->name}}</strong></p>
    					@endif
    				@endforeach
        </p>
      </div>
    </div>
  </div>
</div>