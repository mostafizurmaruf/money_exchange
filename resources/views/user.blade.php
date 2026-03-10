@include('include.header')
<div class="card">
   <div class="card-header">
      <div class="d-flex justify-content-between">
         <div class="card-title">User Table</div>
         <form action="{{route('search')}}" method="post" class="d-flex">
              @csrf
              <input type="hidden" name="page_name" value="user">
              <input type="hidden" name="db" value="users">
              <input type="hidden" name="cl" value="email">
              <input class="form-control mx-2" type="search" placeholder="Search Email" aria-label="Search" name="search">
              <button class="btn btn-primary" type="submit">Search</button>
          </form>
      </div>
   </div>
   <div class="card-body">
      <div class="table-responsive">
         <table class="table table-bordered">
            <thead>
               <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Created At</th>
                  <th>Action</th>
               </tr>
            </thead>
            <tbody>
            	@foreach($data as $item)
               <tr>
                  <th scope="row">{{$item->id}}</th>
                  <td>{{$item->name}}</td>
                  <td>{{$item->email}}</td>
                  <td>{{$item->phone}}</td>
                  <td>{{\Carbon\Carbon::parse($item->created_at)->format("d, M Y")}}</td>
                  <td><button class="btn btn-danger" onclick="deletef('{{$item->id}}','{{ route("user.delete", ["id" => $item->id]) }}')">Delete</button></td>
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