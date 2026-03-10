@include('include.header')
<form action="{{route('add.service.submit')}}" method="post" enctype="multipart/form-data">
	@csrf
	<div class="card">
	   <div class="card-header">
	      <div class="card-title">Add Exchange</div>
	   </div>
	   <div class="card-body">
	   	  <div class="form-group">
	         <label for="exampleFormControlFile1">Icon</label>
	         <input type="file" class="form-control-file" name="thumbnail" required>
	      </div>
	      <div class="form-group">
	         <label for="email">Name</label>
	         <input type="text" class="form-control" name="name" placeholder="Enter Name" required>
	      </div>
	      <div class="form-group">
	         <label for="password">Currency</label>
	         <input type="text" class="form-control" name="currency" placeholder="Enter Currency" required>
	      </div>
	      <div class="form-group">
	         <label for="password">Reserve</label>
	         <input type="number" step="any" class="form-control" name="reserve" placeholder="Enter Reserve" required>
	      </div>
	      <div class="form-group">
	         <label for="password">Min Amount</label>
	         <input type="number" step="any" class="form-control" name="min_amount" placeholder="Enter Min Amount" required>
	      </div>
	      <div class="form-group">
	         <label for="password">Max Amount</label>
	         <input type="number" step="any" class="form-control" name="max_amount" placeholder="Enter Max Amount" required>
	      </div>
	      <div class="form-group">
	         <label for="password">Fee (if currency is same)</label>
	         <input type="number" step="any" class="form-control" name="fee" placeholder="Enter Fee" required>
	         <small>should be in %</small>
	      </div>
	   </div>
	   <div class="card-action">
	      <button type="submit" class="btn btn-success">Submit</button>
	   </div>
	</div>
</form>
@include('include.footer')