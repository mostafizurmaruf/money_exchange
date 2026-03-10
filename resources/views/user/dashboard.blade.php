@include('user.include.header')
@php
    $data = DB::table('gateways')->orderByRaw('RAND()')->get();
    $data1 = DB::table('gateways')->orderByRaw('RAND()')->get();
@endphp
    <main>
        <section id="home" class="section-spacing" style="background-color: #f1f3fa;">
            <div class="container">
                <div class="d-flex rounded" style="padding: 5px;margin-bottom: 20px;">
                    @php
                    $setting_data = DB::table('settings')->first();
                    @endphp
                    <marquee><font color="blue">Notice : </font><font color="black">{{$setting_data->notice}}</font></marquee>
                </div>
                <div class="row mb-5 d-flex justify-content-center">
                    <div class="col-md-8">
                        <div class="contact-info rounded shadow" style="background-color: #0e1849;">
                            <form id="exchangeForm" class="p-3 text-white">
                                @csrf
                                <div class="d-flex justify-content-between m-2">
                                    <div class="d-lg-flex me-3">
                                        <div class="text-center mb-3 me-4">
                                            <img id="bit_image_send" src="{{asset('user/images/exchange.png')}}" width="64" height="64">
                                        </div>
                                        <div>
                                            <label class="mb-1"><i class="bi bi-arrow-down"></i> Send</label><br>
                                            <select class="form-control" id="bit_gateway_send" name="bit_gateway_send" onchange="bit_refresh('1');">
                                                @foreach($data as $item)
                                                <option value="{{$item->id}}">{{$item->name.' '.$item->currency}}</option>
                                                @endforeach
                                            </select>
                                            <div class="input-group mt-2">
                                                <input type="number" step="any" class="form-control" id="bit_amount_send" name="bit_amount_send" value="0" onkeyup="bit_calculator();" onkeydown="bit_calculator();">
                                                <span id="input_sn_txt" class="input-group-text">-</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-lg-flex">
                                        <div class="text-center mb-3 me-4">
                                            <img id="bit_image_receive" src="{{asset('user/images/exchange.png')}}" width="64" height="64">
                                        </div>
                                        <div>
                                            <label class="mb-1"><i class="bi bi-arrow-up"></i> Receive</label><br>
                                            <select class="form-control" id="bit_gateway_receive" name="bit_gateway_receive" onchange="bit_refresh('2');">
                                                @foreach($data1 as $item)
                                                <option value="{{$item->id}}">{{$item->name.' '.$item->currency}}</option>
                                                @endforeach
                                            </select>
                                            <div class="input-group mt-2">
                                                <input type="number" id="bit_amount_receive" class="form-control" step="any" name="bit_amount_receive" placeholder="0.00" required readonly>
                                                <span id="input_rc_txt" class="input-group-text">-</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center mt-5">
                                    <div class="text-white pull-right" style="padding-bottom:10px;font-weight"><small>Exchange rate: <span id="bit_exchange_rate">-</span></small></div>
                                    <input type="hidden" name="bit_rate_from" id="bit_rate_from">
                                    <input type="hidden" name="bit_rate_to" id="bit_rate_to">
                                    <input type="hidden" name="bit_currency_from" id="bit_currency_from">
                                    <input type="hidden" name="bit_currency_to" id="bit_currency_to">
                                    <input type="hidden" name="fees_txt" id="fees_txt">
                                    <button type="submit" class="btn btn-primary mt-2" name="exchangeSubmit">Exchange</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-9">
                        <h3 class="mb-4">Exchanges List</h3>
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" style="font-size: 14px;">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Send</th>
                                                <th>Receive</th>
                                                <th>Amount</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                            $data = DB::table('exchanges')
                                                    ->join('gateways as send_gateway', 'exchanges.gateway_send', '=', 'send_gateway.id')
                                                    ->join('gateways as receive_gateway', 'exchanges.gateway_receive', '=', 'receive_gateway.id')
                                                    ->select(
                                                        'exchanges.*',
                                                        'send_gateway.name as send_gateway_name',
                                                        'receive_gateway.name as receive_gateway_name',
                                                        'receive_gateway.currency as receive_currency'
                                                    )
                                                    ->orderBy('exchanges.id','DESC')
                                                    ->limit(20)
                                                    ->get();
                                            @endphp
                                            @foreach ($data as $transaction)
                                            <tr>
                                                <td>{{ $transaction->id }}</td>
                                                <td>{{ $transaction->send_gateway_name  }}</td>
                                                <td>{{ $transaction->receive_gateway_name  }}</td>
                                                <td>{{ $transaction->amount_receive }} {{ $transaction->receive_currency }}</td>
                                                <td>
                                                    @if ($transaction->status == 0)
                                                        <span class="badge bg-info">Processing</span>
                                                    @elseif ($transaction->status == 1)
                                                        <span class="badge bg-success">Approved</span>
                                                    @elseif ($transaction->status == 2)
                                                        <span class="badge bg-danger">Rejected</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="row">
                            <h3 class="mb-4">Our Reserve</h3>
                            @php
                            $data = DB::table('gateways')->orderByRaw('RAND()')->get();
                            @endphp
                            @foreach($data as $item)
                            <div class="col-md-12 mb-3">
                                <div class="card shadow">
                                    <div class="card-body d-flex">
                                        <img class="me-4" src="{{asset('thumbnails/'.$item->external_icon)}}" width="45" height="45">
                                        <div>
                                            <label>{{$item->name}}</label><br>
                                            <small><b>Reserve : {{$item->reserve}}</b></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                
            </div>
        </section>
    </main>
                                    
@push('script')
<script type="text/javascript">

$("#exchangeForm").on("submit", function(event) {
        event.preventDefault(); // Prevent default form submission

        let formData = new FormData(this);

                Swal.fire({
                    title: "Do you want to Exchange?",
                    html: `
                            <div class="text-left">
                                <p class="d-flex justify-content-between"><strong>Exchange Rate:</strong> ${$("#bit_exchange_rate").text()}</p>
                                <p class="d-flex justify-content-between"><strong>Rate From:</strong> ${$("#bit_rate_from").val()}</p>
                                <p class="d-flex justify-content-between"><strong>Rate To:</strong> ${$("#bit_rate_to").val()}</p>
                                <p class="d-flex justify-content-between"><strong>Currency From:</strong> ${$("#bit_currency_from").val()}</p>
                                <p class="d-flex justify-content-between"><strong>Currency To:</strong> ${$("#bit_currency_to").val()}</p>
                                <p class="d-flex justify-content-between"><strong>Amount Send:</strong> ${$("#bit_amount_send").val()}</p>
                                <p class="d-flex justify-content-between"><strong>Amount Receive:</strong> ${$("#bit_amount_receive").val()}</p>
                                <p class="d-flex justify-content-between"><strong>Sender:</strong> ${$("#input_sn_txt").text()}</p>
                                <p class="d-flex justify-content-between"><strong>Receiver:</strong> ${$("#input_rc_txt").text()}</p>
                            </div>
                        `,
                    showDenyButton: true,
                    showCancelButton: false,
                    confirmButtonText: "Confirm Exchange",
                    denyButtonText: `Cancel Exchange`
                }).then((result) => {
                    if (result.isConfirmed) {
                          $.ajax({
                                url: "{{ route('user.exchange.submit') }}", // Update with your route
                                type: "POST",
                                data: formData,
                                processData: false, // Important for FormData
                                contentType: false, // Important for FormData
                                success: function(response) {
                                    if (response.success) {
                                        window.location.href = "{{route('user.exchange.details')}}";
                                    } else {
                                        Swal.fire('Error !',response.message,'error');
                                    }
                                },
                                error: function(xhr) {
                                    alert("Something went wrong! " + xhr.responseText);
                                }
                            });    
                    }
                });
    });

$(document).ready(function() {
    bit_rates();
    bit_get_gateway_image(1);
    bit_get_gateway_image(2);
});

function bit_refresh(type) {
    bit_rates();
    bit_get_gateway_image(type);
}

function bit_rates() {
    var gateway_send = $("#bit_gateway_send").val();
    var gateway_receive = $("#bit_gateway_receive").val();
    var data_url = "{{url('/exchange')}}"+'/'+gateway_send+'/'+gateway_receive; 
    $.ajax({
        type: "GET",
        url: data_url,
        dataType: "json",
        success: function (data) {
            console.log(data);
            if(data.status == "success") {
                var ex_rate = data.rate_from+" "+data.currency_form+" = "+data.rate_to+" "+data.currency_to;
                $("#bit_exchange_rate").text(ex_rate);
                $("#bit_rate_from").val(data.rate_from);
                $("#bit_rate_to").val(data.rate_to);
                $("#bit_currency_from").val(data.currency_form);
                $("#bit_currency_to").val(data.currency_to);
                $("#bit_amount_send").val(data.rate_from);
                $("#bit_amount_receive").val(data.rate_to);
                $("#input_sn_txt").text(data.currency_form);
                $("#input_rc_txt").text(data.currency_to);
                $("#fees_txt").val(data.fees);
            } else {
                $("#bit_exchange_rate").text("-");
                $("#bit_amount_send").val("0");
                $("#bit_amount_receive").val("0");
                $("#bit_rate_from").val("0");
                $("#bit_rate_to").val("0");
                $("#bit_currency_from").val("");
                $("#bit_currency_to").val("");
                $("#input_sn_txt").val("-");
                $("#input_rc_txt").val("-");
                $("#fees_txt").val("");
            }
        }
    });
}


function bit_get_gateway_image(type) {
    if(type == "1") {
        var gateway_id = $("#bit_gateway_send").val();
    } else if(type == "2") {
        var gateway_id = $("#bit_gateway_receive").val();
    }
    var data_url = "{{url('/image/exchange')}}"+'/'+gateway_id;
    $.ajax({
        type: "GET",
        url: data_url,
        dataType: "json",
        success: function (data) {
            console.log(data.external_icon);
            if(type == "1") {
                $("#bit_image_send").attr("src", "{{url('thumbnails')}}"+'/'+data.external_icon);
            } else if(type == "2") {
                $("#bit_image_receive").attr("src", "{{url('thumbnails')}}"+'/'+data.external_icon);
            }
        }
    });
}


function bit_calculator() {
    var currency_from = $("#bit_currency_from").val();
    var currency_to = $("#bit_currency_to").val();
    var rate_from = $("#bit_rate_from").val();
    var rate_to = $("#bit_rate_to").val();
    var amount_send = $("#bit_amount_send").val();
    if(isNaN(amount_send)) {
        var data = '0';
    } else {
        if(rate_from > 1) {
            var sum = amount_send / rate_from;
            var data = sum.toFixed(2);
        } else {
            var sum = amount_send * rate_to;
            var data = sum.toFixed(2);
        }   
    }
    $("#bit_amount_receive").val(data);
    $("#bit_amount_receive2").val(data);
}

</script>
@endpush

@include('user.include.footer')
