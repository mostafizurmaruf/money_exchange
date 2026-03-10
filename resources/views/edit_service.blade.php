@include('include.header')
<form action="{{route('edit.service.submit')}}" method="post" enctype="multipart/form-data">
	@csrf
	<div class="card">
	   <div class="card-header">
	      <div class="card-title">Edit Exchange</div>
	   </div>
	   <div class="card-body">
	   	  <div class="form-group">
	         <label for="exampleFormControlFile1">Icon</label>
	         <input type="file" class="form-control-file" name="thumbnail">
	         <img class="mt-3" src="{{asset('thumbnails/'.$data->external_icon)}}" width="34">
	      </div>
	      <div class="form-group">
	         <label for="email">Name</label>
	         <input type="text" class="form-control" name="name" value="{{$data->name}}" required>
	      </div>
	      <div class="form-group">
	         <label for="password">Currency</label>
	         <input type="text" class="form-control" name="currency" value="{{$data->currency}}" required>
	      </div>
	      <div class="form-group">
	         <label for="password">Reserve</label>
	         <input type="number" step="any" class="form-control" name="reserve" value="{{$data->reserve}}" required>
	      </div>
	      <div class="form-group">
	         <label for="password">Min Amount</label>
	         <input type="number" step="any" class="form-control" name="min_amount" value="{{$data->min_amount}}" required>
	      </div>
	      <div class="form-group">
	         <label for="password">Max Amount</label>
	         <input type="number" step="any" class="form-control" name="max_amount" value="{{$data->max_amount}}" required>
	      </div>
	      <div class="form-group">
	         <label for="password">Fee (if currency is same)</label>
	         <input type="number" step="any" class="form-control" name="fee" value="{{$data->fee}}" required>
	      </div>
	   </div>
	   <div class="card-action">
	   	  <input type="hidden" name="id" value="{{$data->id}}">
	      <button type="submit" class="btn btn-success">Update</button>
	   </div>
	</div>
</form>
@include('include.footer')