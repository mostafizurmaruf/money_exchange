@include('user.include.header')
    <!-- ==========Main Area Start============ -->
    <main>
        <section id="home" class="section-spacing" style="background-color: #f1f3fa;">
            <div class="container">
                <h3 class="mb-4">Profile</h3>
                <div class="row d-flex justify-content-center">
                    @php
                    $data = Auth::user();
                    @endphp
                    <div class="col-md-8">
                            <div class="card shadow">
                                <div class="card-body">
                                    @if(session('error'))
                                        <div class="alert alert-danger">
                                            <span>{{ session('error') }}</span>
                                        </div>
                                    @elseif(session('success'))
                                        <div class="alert alert-success">
                                            <span>{{ session('success') }}</span>
                                        </div>
                                    @endif
                                    <form action="{{route('user.profile.submit')}}" method="post">
                                        @csrf
                                        <div class="mb-4">
                                            <label>Name</label>
                                            <input type="text" class="form-control" name="name" value="{{$data->name}}" required>
                                        </div>
                                        <div class="mb-4">
                                            <label>Email</label>
                                            <input type="text" class="form-control" name="email" value="{{$data->email}}" readonly>
                                        </div>
                                        <div class="mb-4">
                                            <label>Phone</label>
                                            <input type="text" class="form-control" name="phone" value="{{$data->phone}}" required>
                                        </div>
                                        <div class="mb-4 d-none">
                                            <label>New Password</label>
                                            <input type="password" class="form-control" name="password" placeholder="ex. 12345678">
                                            <small class="text-muted">If you don't want to change the password then forgot this box.</small>
                                        </div>
                                        <div class="mb-4">
                                            <button type="submit" class="btn btn-success">Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <!-- ==========Main Area End============ -->   
@include('user.include.footer')