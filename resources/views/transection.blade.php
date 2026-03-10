@include('include.header')
<div class="card">
   <div class="card-header">
      <div class="d-flex justify-content-between">
         <div class="card-title">Transection Table</div>
         <form action="{{route('search')}}" method="post" class="d-flex">
              @csrf
              <input type="hidden" name="page_name" value="transection">
              <input type="hidden" name="db" value="exchanges">
              <input type="hidden" name="cl" value="transaction_id">
              <input class="form-control mx-2" type="search" placeholder="Search Trxid" aria-label="Search" name="search">
              <button class="btn btn-primary" type="submit">Search</button>
          </form>
      </div>
   </div>
   <div class="card-body">
      <div class="table-responsive">
                                         <table class="table table-bordered" style="font-size: 14px;">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Order ID</th>
                                                        <th>Gateway Send</th>
                                                        <th>Gateway Receive</th>
                                                        <th>Amount Send</th>
                                                        <th>Amount Receive</th>
                                                        <th>Rate From</th>
                                                        <th>Rate To</th>
                                                        <th>Fees</th>
                                                        <th>Status</th>
                                                        <th>Created</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($data as $transaction)
                                                    <tr>
                                                        <td>{{ $transaction->id }}</td>
                                                        <td>{{ $transaction->order_id }}</td>
                                                        <td>{{ $transaction->send_gateway_name  }}</td>
                                                        <td>{{ $transaction->receive_gateway_name  }}</td>
                                                        <td>{{ $transaction->amount_send }}</td>
                                                        <td>{{ $transaction->amount_receive }}</td>
                                                        <td>{{ $transaction->rate_from }}</td>
                                                        <td>{{ $transaction->rate_to }}</td>
                                                        <td><span class="{{ $transaction->fees < 0 ? 'badge bg-danger text-white' : 'badge bg-success text-white' }}">{{ $transaction->fees }}</span></td>
                                                        <td>
                                                           <span class="badge status-badge text-white" 
                                                                  data-id="{{ $transaction->id }}" 
                                                                  data-status="{{ $transaction->status }}"
                                                                  style="cursor: pointer;">
                                                                @if ($transaction->status == 0)
                                                                    <span class="badge bg-info">Processing</span>
                                                                @elseif ($transaction->status == 1)
                                                                    <span class="badge bg-success">Approved</span>
                                                                @elseif ($transaction->status == 2)
                                                                    <span class="badge bg-danger">Rejected</span>
                                                                @endif
                                                            </span>
                                                        </td>
                                                        <td>{{ \Carbon\Carbon::parse($transaction->created)->format('d, M Y') }}</td>
                                                        <td class="d-flex">
                                                           <button class="btn btn-success mx-2" onclick="viewf('{{ $transaction->id }}')">View</button>
                                                           <button class="btn btn-danger" onclick="deletef('{{$transaction->id}}','{{ route("transection.delete", ["id" => $transaction->id]) }}')">Delete</button>
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


   function viewf(id) {
    // Fetch transaction data using AJAX
    $.ajax({
        url: "{{ route('transaction.details') }}", // Your route to fetch transaction details
        type: "GET",
        data: { id: id },
        success: function(response) {
            if (response.success) {
                // Show transaction details in SweetAlert
                Swal.fire({
                    title: "",
                    html: `
                        <b>Payeer ID:</b> ${response.transaction.payeer_id} <br> 
                        <b>Transaction ID:</b> ${response.transaction.transaction_id}`,
                    icon: "info",
                    confirmButtonText: "OK"
                });
            } else {
                Swal.fire("Error!", response.message, "error");
            }
        },
        error: function() {
            Swal.fire("Error!", "Something went wrong.", "error");
        }
    });
}



   $(".status-badge").on("click", function() {
        let transactionId = $(this).data("id");
        let currentStatus = $(this).data("status");

        Swal.fire({
            title: "Change Transaction Status",
            text: "Select the new status for this transaction:",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Approve",
            denyButtonText: "Processing",
            cancelButtonText: "Reject",
            showDenyButton: true,
        }).then((result) => {
            let newStatus = null;

            if (result.isConfirmed) {
                newStatus = 1; // Approved
            } else if (result.isDenied) {
                newStatus = 0; // Processing
            } else {
                newStatus = 2; // Rejected
            }

            // Send AJAX Request to Update Status
            $.ajax({
                url: "{{ route('transaction.status') }}", // Update with your route
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: transactionId,
                    status: newStatus
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire("Updated!", response.message, "success").then(() => {
                            location.reload(); // Refresh the page to show updated status
                        });
                    } else {
                        Swal.fire("Error!", response.message, "error");
                    }
                },
                error: function() {
                    Swal.fire("Error!", "Something went wrong.", "error");
                }
            });
        });
    });

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