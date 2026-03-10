@include('include.header')
<div class="card">
   <div class="card-header">
      <div class="d-flex justify-content-between">
         <div class="card-title">Rates Table</div>
         <div class="d-flex justify-content-end">
            <a class="btn btn-primary" href="{{route('add.rates')}}">Add Rates</a>
         </div>
      </div>
   </div>
   <div class="card-body">
      <div class="table-responsive">
         <table class="table table-bordered">
            <thead>
               <tr>
                  <th>#</th>
                  <th>Gateway From</th>
                  <th>Gateway To</th>
                  <th>Rate From</th>
                  <th>Rate To</th>
                  <th>Action</th>
               </tr>
            </thead>
            <tbody>
            	@foreach($data as $item)
               <tr>
                  <th scope="row">{{$item->id}}</th>
                  <td>{{$item->send_gateway_name}}</td>
                  <td>{{$item->receive_gateway_name}}</td>
                  <td>{{$item->rate_from}} {{$item->send_gateway_currency}}</td>
                  <td>{{$item->rate_to}} {{$item->receive_gateway_currency}}</td>
                  <td class="d-flex">
                     <a href="{{route('edit.rates',['id' => $item->id])}}" class="btn btn-success text-white mx-2">Edit</a>
                     <button class="btn btn-danger" onclick="deletef('{{$item->id}}','{{ route("rates.delete", ["id" => $item->id]) }}')">Delete</button>
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