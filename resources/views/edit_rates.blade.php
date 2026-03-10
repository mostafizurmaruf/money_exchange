@include('include.header')
<form action="{{route('edit.rates.submit')}}" method="post">
	@csrf
	<div class="card">
	   <div class="card-header">
	      <div class="card-title">Edit Rate</div>
	   </div>
	   <div class="card-body">
	      <div class="form-group">
	         <label for="email">Gateway From</label>
	         <select name="gateway_from" class="form-control" required>
	         	@php
	         	$row1 = DB::table('gateways')->whereId($data->gateway_from)->first();
	         	@endphp
	         	<option value="{{$row1->id}}">{{$row1->name}} {{$row1->currency}}</option>
	         	@php
	         	$row = DB::table('gateways')->get();
	         	@endphp
	         	@foreach($row as $item)
	         		<option value="{{$item->id}}">{{$item->name}} {{$item->currency}}</option>
	         	@endforeach
	         </select>
	      </div>
	      <div class="form-group">
	         <label for="password">Gateway To</label>
	         <select name="gateway_to" class="form-control" required>
	         	@php
	         	$row1 = DB::table('gateways')->whereId($data->gateway_to)->first();
	         	@endphp
	         	<option value="{{$row1->id}}">{{$row1->name}} {{$row1->currency}}</option>
	         	@php
	         	$row = DB::table('gateways')->get();
	         	@endphp
	         	@foreach($row as $item)
	         		<option value="{{$item->id}}">{{$item->name}} {{$item->currency}}</option>
	         	@endforeach
	         </select>
	      </div>
	      <div class="form-group">
	         <label for="password">Rate From</label>
	         <input type="number" step="any" class="form-control" name="rate_from" value="{{$data->rate_from}}" required>
	      </div>
	      <div class="form-group">
	         <label for="password">Rate To</label>
	         <input type="number" step="any" class="form-control" name="rate_to" value="{{$data->rate_to}}" required>
	      </div>
	   </div>
	   <div class="card-action">
	      <button type="submit" class="btn btn-success">Update</button>
	   </div>
	</div>
</form>
@include('include.footer')