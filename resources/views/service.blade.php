@include('include.header')
<div class="card">
   <div class="card-header">
      <div class="d-flex justify-content-between">
         <div class="card-title">Exchange Table</div>
         <div class="d-flex justify-content-end">
            <a class="btn btn-primary" href="{{route('add.service')}}">Add Exchange</a>
            <form action="{{route('search')}}" method="post" class="d-flex">
                 @csrf
                 <input type="hidden" name="page_name" value="service">
                 <input type="hidden" name="db" value="gateways">
                 <input type="hidden" name="cl" value="name">
                 <input class="form-control mx-2" type="search" placeholder="Search Name" aria-label="Search" name="search">
                 <button class="btn btn-primary" type="submit">Search</button>
             </form>
         </div>
      </div>
   </div>
   <div class="card-body">
      <div class="table-responsive">
         <table class="table table-bordered">
            <thead>
               <tr>
                  <th>#</th>
                  <th>Icon</th>
                  <th>Name</th>
                  <th>Currency</th>
                  <th>Reserve</th>
                  <th>Min Amount</th>
                  <th>Max Amount</th>
                  <th>Fee</th>
                  <th>Created At</th>
                  <th>Action</th>
               </tr>
            </thead>
            <tbody>
            	@foreach($data as $item)
               <tr>
                  <th scope="row">{{$item->id}}</th>
                  <td><img src="{{asset('thumbnails/'.$item->external_icon)}}" width="34"></td>
                  <td>{{$item->name}}</td>
                  <td>{{$item->currency}}</td>
                  <td>{{$item->reserve}}</td>
                  <td>{{$item->min_amount}}</td>
                  <td>{{$item->max_amount}}</td>
                  <td>{{$item->fee}}</td>
                  <td>{{\Carbon\Carbon::parse($item->created_at)->format("d, M Y")}}</td>
                  <td class="d-flex">
                     <a href="{{route('edit.service',['id' => $item->id])}}" class="btn btn-success text-white mx-2">Edit</a>
                     <button class="btn btn-danger" onclick="deletef('{{$item->id}}','{{ route("service.delete", ["id" => $item->id]) }}')">Delete</button>
                  </td>
               </tr>
               @endforeach
            </tbody>
         </table>
      </div>
      <div class="d-flex justify-content-end">
      		{{$data->links('pagination::bootstrap-4')}}
      </div>
   </div>
</div>
@push("javascript")
<script type="text/javascript">
	function deletef(id,url){
		Swal.fire({
		  title: "Are you sure?",
		  text: "You won't be able to revert this!",
		  icon: "warning",
		  showCancelButton: true,
		  confirmButtonColor: "#3085d6",
		  cancelButtonColor: "#d33",
		  confirmButtonText: "Yes, delete it!"
		}).then((result) => {
		  if (result.isConfirmed) {
		  	  window.location.href = url;
		  }
		});
	}
</script>
@endpush
@include('include.footer')