@include('user.include.header')
    <!-- ==========Main Area Start============ -->
    <main>
        <section id="home" class="section-spacing" style="background-color: #f1f3fa;">
            <div class="container">
                <h3 class="mb-4">Exchange</h3>
                <div class="row">
                    @php
                    $data = DB::table('exchanges')->where('uid', Auth::user()->id)
                            ->join('gateways as send_gateway', 'exchanges.gateway_send', '=', 'send_gateway.id')
                            ->join('gateways as receive_gateway', 'exchanges.gateway_receive', '=', 'receive_gateway.id')
                            ->select(
                                'exchanges.*',
                                'send_gateway.name as send_gateway_name',
                                'receive_gateway.name as receive_gateway_name'
                            )
                            ->paginate(10);
                    @endphp
                    <div class="col-md-12">
                            <div class="card shadow">
                                <div class="card-body">
                                    <div class="table-responsive">
                                         <table class="table table-bordered" style="font-size: 14px;">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Transaction ID</th>
                                                        <th>Gateway Send</th>
                                                        <th>Gateway Receive</th>
                                                        <th>Amount Send</th>
                                                        <th>Amount Receive</th>
                                                        <th>Rate From</th>
                                                        <th>Rate To</th>
                                                        <th>Fees</th>
                                                        <th>Status</th>
                                                        <th>Created</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($data as $transaction)
                                                    <tr>
                                                        <td>{{ $transaction->id }}</td>
                                                        <td>{{ $transaction->transaction_id }}</td>
                                                        <td>{{ $transaction->send_gateway_name  }}</td>
                                                        <td>{{ $transaction->receive_gateway_name  }}</td>
                                                        <td>{{ $transaction->amount_send }}</td>
                                                        <td>{{ $transaction->amount_receive }}</td>
                                                        <td>{{ $transaction->rate_from }}</td>
                                                        <td>{{ $transaction->rate_to }}</td>
                                                        <td><span class="{{ $transaction->fees < 0 ? 'badge bg-danger' : 'badge bg-success' }}">{{ $transaction->fees }}</span></td>
                                                        <td>
                                                            @if ($transaction->status == 0)
                                                                <span class="badge bg-info">Processing</span>
                                                            @elseif ($transaction->status == 1)
                                                                <span class="badge bg-success">Approved</span>
                                                            @elseif ($transaction->status == 2)
                                                                <span class="badge bg-danger">Rejected</span>
                                                            @endif
                                                        </td>
                                                        <td>{{ \Carbon\Carbon::parse($transaction->created)->format('d, M Y') }}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <!-- ==========Main Area End============ -->   
@include('user.include.footer')