@extends('partials.template')

@section('title', 'Admin Page')

@section('content')
@if (Session::has('approve'))
	<div class="alert alert-success">
		{{Session::get('approve')}}
	</div>
@endif
@if (Session::has('declined'))
	<div class="alert alert-danger">
		{{Session::get('declined')}}
	</div>
@endif
	<h1 class="text-center mt-3" align="center"><i class="fas fa-book-open"> Book Requests</i></h1>
	<h2 class="text-center">Welcome, Administrator</h2>
	<div class="container text-center mb-5">
		<table class="table table-striped text-center">
			<thead class="text-center thead-light">
				<tr>
					<td class="align-middle"><strong><i class="fas fa-hashtag"></i> Request Number</strong></td>
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
						@if ($user->pivot->status == 0)
						<tr style="border: 5px solid black;" id="row{{$user->pivot->user_id}}{{$request->id}}">
							<td class="align-middle">{{$user->pivot->id}}</td>
							<td class="align-middle">{{$user->name}}</td>
							<td class="align-middle">
								<div>
									<div class="mb-2"><em >{{$request->name}}</em></div>
									<div><img src="{{$request->image}}" width="100" height="100" style="border: 5px solid black;"></div>
								</div>
							</td>
							<td class="align-middle">{{$user->pivot->created_at}}</td>
							<td class="align-middle">{{$user->pivot->quantity}}</td>
							<td></td>
							<td class="align-middle" data-id="{{$user->pivot->user_id}}" data-bid="{{$request->id}}" data-qty="{{$user->pivot->quantity}}" data-name="{{$request->name}}">
								<button class="btn btn-success accept mb-2"><i class="fas fa-thumbs-up"></i> Accept</button><br>
								<button class="btn btn-danger decline"><i class="fas fa-thumbs-down"></i> Decline</button>
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

		let acceptReqs = document.querySelectorAll('.accept');
		acceptReqs.forEach( function(acceptReq){
		acceptReq.addEventListener('click', function(e){
			let id = e.target.parentElement.getAttribute('data-id');
			let bid = e.target.parentElement.getAttribute('data-bid');
			let qty = e.target.parentElement.getAttribute('data-qty');
			let data = new FormData;
			data.append('_method', 'PUT');
			data.append('_token', csrfToken);

			fetch ('/admin/'+id+'/'+bid+'/'+qty+'/approve', {
					method: 'post',
					body: data
				})
				.then( function(res) {
					return res.text();
				}).then( function(data){
					console.log('Approved');
					document.querySelector('#row'+id+bid).remove();
				})
			})
		})

		let declineReqs = document.querySelectorAll('.decline');
		declineReqs.forEach( function(declineReq) {
		declineReq.addEventListener('click', function(e){
			let id = e.target.parentElement.getAttribute('data-id');
			let bid = e.target.parentElement.getAttribute('data-bid');
			let data = new FormData;

			data.append('_method', 'DELETE');
			data.append('_token', csrfToken);

			fetch ('/admin/'+id+'/'+bid+'/decline', {
					method: 'post',
					body: data
				})
				.then( function(res) {
					return res.text();
				}).then( function(data){
					console.log('Declined');
					document.querySelector('#row'+id+bid).remove();
				})
			})
		})

	</script>
	
@endsection