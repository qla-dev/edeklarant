@extends('layouts.master-without-nav')
@section('title')
@lang('translation.signup')
@endsection
@section('content')

<div class="auth-page-wrapper pt-5">
    <!-- auth page bg -->
    <div class="auth-one-bg-position auth-one-bg" id="auth-particles">
        <div class="bg-overlay" style="opacity:.3!important"></div>

        <div class="shape">
            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                viewBox="0 0 1440 120">
                <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
            </svg>
        </div>
    </div>

    <!-- auth page content -->
    <div class="auth-page-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center mt-sm-5 mb-4 text-info">
                        <div>
                            <a href="index" class="d-inline-block auth-logo">
                                <img src="{{ URL::asset('build/images/logo-dark-ai.png') }}" alt="" height="35">
                            </a>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end row -->

            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card mt-4">
                        <div class="card-body p-4">
                            <div class="text-center mt-2">
                                <h5 class="text-info fw-bold">Kreiraj novi deklarant.ai račun</h5>
                                <p class="text-muted">Napravite svoj besplatni nalog</p>
                            </div>
                            <div class="p-2 mt-4">
                                <form id="registerForm" enctype="multipart/form-data">
                                    <div class="mb-3">
                                        <label for="useremail" class="form-label text-info">Email <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" name="email" id="useremail" placeholder="Unesite email adresu" required>
                                        <div class="invalid-feedback">Please enter email</div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="username" class="form-label text-info">Username <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="username" id="username" placeholder="Unesite korisničko ime" required>
                                        <div class="invalid-feedback">Please enter username</div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="userpassword" class="form-label text-info">Password <span class="text-danger">*</span></label>
                                        <input type="password" class="form-control" name="password" id="userpassword" placeholder="Unesite password" required>
                                        <div class="invalid-feedback">Please enter password</div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="input-password" class="text-info">Potvrdite password <span class="text-danger">*</span></label>
                                        <input type="password" class="form-control" name="confirm_password" id="input-password" placeholder="Ponovo unesite password" required>
                                    </div>


                                    <div class="mt-3">
                                        <button class="btn btn-info w-100 fw-bold" type="submit">Registrujte se</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 text-center ">
                        <p class="text-info mb-0">Već imate nalog? <a href="{{ route('login') }}" class="fw-semibold text-info text-decoration-underline"> Prijava </a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center">
                        <script>
                            document.write(new Date().getFullYear())
                        </script> deklarant.ai <i class="mdi mdi-heart text-info"></i> Razvijeno od strane <span class="logo-lg">
                            <img src="{{ URL::asset('build/images/logo-qla.png') }}" alt="" height="17" style="margin-top:-3px">
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div>
@endsection
@section('script')
<script src="{{ URL::asset('build/libs/particles.js/particles.js') }}"></script>
<script src="{{ URL::asset('build/js/pages/particles.app.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const form = document.getElementById("registerForm");

        form.addEventListener("submit", async function (e) {
            e.preventDefault();

            const macAddress = '11:22:33:44:55'; // optional: make dynamic later

            try {
                const formData = new FormData(form);

                const registerResponse = await axios.post("/api/auth/register", formData, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                        "MAC-Address": macAddress
                    }
                });

                const { token, user, message } = registerResponse.data;

                // Save token & user info
                localStorage.setItem("auth_token", token);
                localStorage.setItem("user", JSON.stringify(user));
                axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;

                Swal.fire({
                    icon: 'success',
                    title: 'Registracija uspješna!',
                    text: message || 'Uspješno ste registrovani',
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    window.location.href = "/";
                });

            } catch (error) {
                console.error("Registration failed:", error);
                const msg = error.response?.data?.message || "Došlo je do greške prilikom registracije";

                Swal.fire({
                    icon: 'error',
                    title: 'Greška',
                    text: msg
                });
            }
        });
    });
</script>



@endsection