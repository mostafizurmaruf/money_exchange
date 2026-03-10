@include('user.include.header')
    <!-- ==========Main Area Start============ -->
    <main>
        <section id="home" class="section-spacing" style="background-color: #f1f3fa;">
            <div class="container">
                <h3 class="mb-4">Exchange</h3>
                <div class="row d-flex justify-content-center">
                    <div class="col-md-8">
                            <div class="card shadow mb-3">
                                <div class="card-body">
                                    <b>Notice :</b><br><br>
                                    {!! DB::table('settings')->value('withdraw_info') !!}
                                </div>
                            </div>
                            <div class="card shadow">
                                <div class="card-body">
                                    @if(session('success'))
                                        <div class="alert alert-success">
                                            {{ session('success') }}
                                        </div>
                                    @else
                                    <form action="{{route('user.exchange.details.submit')}}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-4">
                                            <label>Enter Your Withdraw Details</label>
                                            <textarea class="form-control" rows="4" name="payeer_id" required></textarea>
                                        </div>
                                        <div class="mb-4">
                                            <label>Enter Transection Id</label>
                                            <input type="text" class="form-control" name="trxid" required>
                                        </div>
                                        <div class="mb-4">
                                            <button type="submit" class="btn btn-success">Order</button>
                                        </div>
                                    </form>
                                    @endif
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <!-- ==========Main Area End============ -->   
@include('user.include.footer')