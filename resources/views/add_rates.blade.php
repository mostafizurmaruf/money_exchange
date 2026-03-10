@include('include.header')
<form action="{{route('add.rates.submit')}}" method="post">
	@csrf
	<div class="card">
	   <div class="card-header">
	      <div class="card-title">Add Rate</div>
	   </div>
	   <div class="card-body">
	      <div class="form-group">
	         <label for="email">Gateway From</label>
	         <select name="gateway_from" class="form-control" required>
	         	@php
	         	$data = DB::table('gateways')->get();
	         	@endphp
	         	@foreach($data as $item)
	         		<option value="{{$item->id}}">{{$item->name}} {{$item->currency}}</option>
	         	@endforeach
	         </select>
	      </div>
	      <div class="form-group">
	         <label for="password">Gateway To</label>
	         <select name="gateway_to" class="form-control" required>
	         	@php
	         	$data = DB::table('gateways')->get();
	         	@endphp
	         	@foreach($data as $item)
	         		<option value="{{$item->id}}">{{$item->name}} {{$item->currency}}</option>
	         	@endforeach
	         </select>
	      </div>
	      <div class="form-group">
	         <label for="password">Rate From</label>
	         <input type="number" step="any" class="form-control" name="rate_from" placeholder="Enter Rate From" required>
	      </div>
	      <div class="form-group">
	         <label for="password">Rate To</label>
	         <input type="number" step="any" class="form-control" name="rate_to" placeholder="Enter Rate To" required>
	      </div>
	   </div>
	   <div class="card-action">
	      <button type="submit" class="btn btn-success">Submit</button>
	   </div>
	</div>
</form>
@include('include.footer')