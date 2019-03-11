@extends('partials.template')

@section('title', 'Customer Requests')

@section('content')
<div class="container text-center mb-5">
	<h1 class="text-center mt-3" align="center"><i class="fas fa-book-open"> Pending Book Requests</i></h1>
	<table class="table table-striped text-center">
		<thead class="text-center thead-light">
			<tr>
				<td class="align-middle"><strong><i class="fas fa-hashtag"></i> Request Number</strong></td>
				<td class="align-middle"><strong><i class="fas fa-book"></i> Book</strong></td>
				<td class="align-middle"><strong><i class="far fa-clock"></i> Date</strong></td>
				<td><strong><i class="fab fa-creative-commons-zero"></i> Quantity</strong></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
		</thead>
		<tbody>
			@foreach($user->books as $book)
			@if($book->pivot->status == 0)
				<tr style="border: 5px solid black;">
					<td class="align-middle">{{$book->pivot->id}}</td>
					<td class="align-middle">
						<div>
							<div class="mb-2"><em >{{$book->name}}</em></div>
							<div><img src="{{$book->image}}" width="100" height="100" style="border: 5px solid black;"></div>
						</div>
					</td>
					<td class="align-middle">{{$book->pivot->created_at}}</td>
					<td class="align-middle">{{$book->pivot->quantity}}</td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				@endif
			@endforeach
		</tbody>
	</table>
</div>

<div class="container text-center mt-5">
	<h1 class="text-center mt-3" align="center"><i class="fas fa-book-open"> Pending Book Returns</i></h1>
	<table class="table table-striped text-center">
		<thead class="text-center thead-light">
			<tr>
				<td class="align-middle"><strong><i class="fas fa-hashtag"></i> Request Number</strong></td>
				<td class="align-middle"><strong><i class="fas fa-book"></i> Book</strong></td>
				<td class="align-middle"><strong><i class="far fa-clock"></i> Date</strong></td>
				<td><strong><i class="fab fa-creative-commons-zero"></i> Quantity</strong></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
		</thead>
		<tbody>
			@foreach($user->books as $book)
			@if($book->pivot->status == 1)
				<tr style="border: 5px solid black;">
					<td class="align-middle">{{$book->pivot->id}}</td>
					<td class="align-middle">
						<div>
							<div class="mb-2"><em >{{$book->name}}</em></div>
							<div><img src="{{$book->image}}" width="100" height="100" style="border: 5px solid black;"></div>
						</div>
					</td>
					<td class="align-middle">{{$book->pivot->created_at}}</td>
					<td class="align-middle">{{$book->pivot->quantity}}</td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				@endif
			@endforeach
		</tbody>
	</table>
</div>



@endsection