@extends('partials.template')

@section('title', 'Return Page')

@section('content')
@if (Session::has('returned'))
	<div class="alert alert-success">
		{{Session::get('returned')}}
	</div>
@endif
	<h1 class="text-center mt-3" align="center"><i class="fas fa-book-open"> Book Returns</i></h1>
	<h2 class="text-center">Welcome, Administrator</h2>
	<div class="container text-center mb-5">
		<table class="table table-striped text-center">
			<thead class="text-center thead-light">
				<tr>
					<td class="align-middle"><strong><i class="fas fa-hashtag"></i> Return Number</strong></td>
					<td class="align-middle"><strong><i class="fas fa-user-tie"></i> Borrower</strong></td>
					<td class="align-middle"><strong><i class="fas fa-book"></i> Book</strong></td>
					<td class="align-middle"><strong><i class="far fa-clock"></i> Date</strong></td>
					<td><strong><i class="fab fa-creative-commons-zero"></i> Quantity</strong></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
			</thead>
			<tbody>
				@foreach($requests as $request)
					@foreach($request->users as $user)
					@if ($user->pivot->status == 1)
						<tr style="border: 5px solid black;" id="row{{$user->pivot->user_id}}{{$request->id}}{{$user->pivot->id}}">
							<td class="align-middle">{{$user->pivot->id}}</td>
							<td class="align-middle">{{$user->name}}</td>
							<td class="align-middle">
								<div>
									<div class="mb-2"><em >{{$request->name}}</em></div>
									<div><img src="{{$request->image}}" width="100" height="100" style="border: 5px solid black;"></div>
								</div>
							</td>
							<td class="align-middle">{{$user->pivot->created_at}}</td>
							<td class="align-middle"><input id="returnQty" type="number" name="return" value="{{$user->pivot->quantity}}"></td>
							<td></td>
							<td class="align-middle" data-table="{{$user->pivot->id}}" data-id="{{$user->pivot->user_id}}" data-bid="{{$request->id}}" data-qty="{{$user->pivot->quantity}}" data-name="{{$request->name}}">
								<button class="btn btn-success return mb-2"><i class="fas fa-undo"></i> Return</button><br>
							</td>
							<td></td>
						</tr>
					@endif
					@endforeach
				@endforeach
			</tbody>
		</table>
	</div>

	<script type="text/javascript">
		const csrfToken =document.querySelector('meta[name="csrf-token"]').getAttribute('content');

		let returnReqs = document.querySelectorAll('.return');
		returnReqs.forEach( function(returnReq){
		returnReq.addEventListener('click', function(e){
			let id = e.target.parentElement.getAttribute('data-id');
			let bid = e.target.parentElement.getAttribute('data-bid');
			let qty = e.target.parentElement.getAttribute('data-qty');
			let bookuser = e.target.parentElement.getAttribute('data-table');
			let data = new FormData;
			data.append('_method', 'PUT');
			data.append('_token', csrfToken);

			fetch ('/admin/'+id+'/'+bid+'/'+bookuser+'/'+qty+'/return', {
					method: 'post',
					body: data
				})
				.then( function(res) {
					return res.text();
				}).then( function(data){
					console.log('Returned');
					document.querySelector('#row'+id+bid+bookuser).remove();
				})
			})
		})

	</script>
	
@endsection