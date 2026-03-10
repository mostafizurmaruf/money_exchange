@include('user.include.header')
    <!-- ==========Main Area Start============ -->
    <main>

        <!-- hero section start -->
        <section id="home" class="hero-area section-spacing">
            <div class="container">
                <div class="row">
                    <!-- left text area -->
                    <div class="col col-xl-6 col-lg-6 col-md-12 col-12">
                        <div class="left-content">
                            <div class="left-text-content">
                                <h5 class="fade-effect" data-fade-direction="left" data-fade-time="1">How Cryptocurrency
                                    Change</h5>
                                <h1 class="fade-effect" data-fade-direction="left" data-fade-time="1.5">Reshaping the
                                    Global Economy</h1>
                                <p class="fade-effect" data-fade-direction="left" data-fade-time="2">Leveraging the
                                    right tech solutions is crucial for startups aiming efficiently and
                                    maintain a competitive edge.</p>
                            </div>
                            <div class="left-buttons">
                                <button id="buy-btn" class="main-btn fade-effect" data-fade-direction="bottom" data-fade-time="2.5">Exchange</button>
                                <script type="text/javascript">
                                    document.getElementById('buy-btn').addEventListener('click', function () {
                                        window.location.href = "{{ route('user.login') }}";
                                    });
                                </script>
                            </div>
                        </div>
                    </div>
                    <div class="col col-xl-6 col-lg-6 col-md-12 col-12">
                        <!-- right image -->
                        <div class="right-image fade-effect" data-fade-direction="right" data-fade-time="2">
                            <img src="{{asset('user')}}/images/hero-right-image.png" alt="hero-right-img">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- hero section end -->


        <!-- about section start -->
        <section id="about" class="about-area section-spacing">
            <div class="container">
                <div class="row">
                    <!-- left content/ left image -->
                    <div class="col col-xl-6 col-lg-6 col-md-12 col-12 d-flex align-items-center">
                        <div class="right-image fade-effect" data-fade-direction="left" data-fade-time="2">
                            <img class="img-fluid" src="{{asset('user')}}/images/about.png" alt="about-img">
                        </div>
                    </div>
                    <!-- left right content -->
                    <div class="col col-xl-6 col-lg-6 col-md-12 col-12">
                        <div class="about-text text-start ps-lg-5">
                            <h3 class="fade-effect" data-fade-direction="bottom" data-fade-time="1">About Cryptocox</h3>
                            <h2 class="fade-effect" data-fade-direction="bottom" data-fade-time="2">Powerful mining
                                invest with Safe & Secure</h2>
                            <p class="fade-effect" data-fade-direction="bottom" data-fade-time="2.25">Leveraging the
                                right tech solutions is crucial for startups aiming efficiently and
                                maintain a competitive edge. Leveraging the right tech solutions is cru cial for
                                startups aimingefficiently and maintain a competitive edge.</p>
                            <br>
                            <p class="fade-effect" data-fade-direction="bottom" data-fade-time="2.5">Leveraging the
                                right tech solutions is crucial for startups aiming efficienly
                                and maintain a competitive edge. Leveraging the right tech solutions is crcial for
                                startups aimingefficiently and maintain a competitive edge.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- about section end -->

        <!-- Our Team section start -->
        <section class="our-team-area section-spacing">
            <div class="container">
                <div class="d-flex rounded" style="padding: 5px;margin-bottom: 20px;background-color: #071037;">
                    @php
                    $setting_data = DB::table('settings')->first();
                    @endphp
                    <marquee><font color="yellow">Notice : </font><font color="white">{{$setting_data->notice}}</font></marquee>
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
        <!-- Our Team section end -->
    </main>
    <!-- ==========Main Area End============ -->
@include('user.include.footer')