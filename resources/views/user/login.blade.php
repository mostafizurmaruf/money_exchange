@include('user.include.header')
    <!-- ==========Main Area Start============ -->
    <main>
        <section id="home" class="section-spacing" style="background-color: #f1f3fa;">
            <div class="container">
                <div class="row">
                  <div class="col-xl-11 col-xxl-12 text-center">
                    <div class="h-n80">
                      <img src="https://bootstrapdemos.adminmart.com/modernize/dist/assets/images/backgrounds/login-security.svg" alt="modernize-img" class="img-fluid" width="500">
                    </div>
                    <div class="text-center">
                        <h2 class="mb-5 fs-7 fw-bolder">Welcome to Cryptocox</h2>
                        <a class="btn text-dark border fw-normal bg-white rounded" href="{{route('user.redirectToGoogle')}}">
                            <img src="https://bootstrapdemos.adminmart.com/modernize/dist/assets/images/svgs/google-icon.svg" alt="modernize-img" class="img-fluid me-2" width="18" height="18">
                            <span class="flex-shrink-0">with Google</span>
                        </a>
                      </div>
                  </div>
                </div>
            </div>
        </section>
    </main>
    <!-- ==========Main Area End============ -->   
@include('user.include.footer')