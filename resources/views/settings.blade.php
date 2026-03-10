@include('include.header')
<form action="{{route('settings.submit')}}" method="post" enctype="multipart/form-data">
	@csrf
	<div class="card">
	   <div class="card-header">
	      <div class="card-title">Settings</div>
	   </div>
	   @php
	   $data = DB::table('settings')->first();
	   @endphp
	   <div class="card-body">
	      <div class="form-group">
	         <label for="email">Our Payment Info</label>
	         <textarea class="form-control" name="withdraw_info" required rows="5">{{$data->withdraw_info}}</textarea>
	      </div>
	      <div class="form-group">
	         <label for="password">ExchangeRate-API</label>
	         <input type="text" class="form-control" name="exchange_api" value="{{$data->exchangerate_api}}" required>
	         <small>for automatic currency please collect your api in <a href="https://www.exchangerate-api.com/">exchangerate-api.com</a> </small>
	      </div>
	      <div class="form-group">
	         <label for="notice">Notice Info</label>
	         <textarea class="form-control" name="notice" required rows="5">{{$data->notice}}</textarea>
	      </div>
	   </div>
	   <div class="card-action">
	      <button type="submit" class="btn btn-success">Submit</button>
	   </div>
	</div>
</form>
<form action="{{route('settings.submit')}}" method="post" enctype="multipart/form-data">
	@csrf
	<div class="card">
	   <div class="card-header">
	      <div class="card-title">Admin Profile</div>
	   </div>
	   <div class="card-body">
	      <div class="form-group">
	         <label for="password">Password</label>
	         <input type="text" class="form-control" name="password" placeholder="password" required>
	      </div>
	   </div>
	   <div class="card-action">
	      <button type="submit" class="btn btn-success">Submit</button>
	   </div>
	</div>
</form>
<form action="{{route('settings.submit')}}" method="post" enctype="multipart/form-data">
	@csrf
	<div class="card">
	   <div class="card-header">
	      <div class="card-title">Web Page</div>
	   </div>
	   <div class="card-body">
	      <div class="form-group">
	         <label for="password">Logo</label>
	         <input type="file" class="form-control" name="logo" required>
	      </div>
	      <div class="form-group">
	         <label for="password">Favicon</label>
	         <input type="file" class="form-control" name="favicon" required>
	      </div>
	   </div>
	   <div class="card-action">
	      <button type="submit" class="btn btn-success">Submit</button>
	   </div>
	</div>
</form>
@include('include.footer')