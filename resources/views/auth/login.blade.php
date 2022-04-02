@extends('layouts.app')
@section('content')
<div id="auth">
    <div class="row h-100">
        <div class="col-lg-5 col-12">
            <div id="auth-left">
                <div class="auth-logo">
                    <a href="#"><img style="width: 10rem;    height: 5rem;" src="assets/images/logo/logo.png" alt="Logo"></a>
                </div>
                {{-- message --}}
                {!! Toastr::message() !!}
                <h1 class="auth-title">Log in.</h1>
                <p class="auth-subtitle mb-5">Log in with your data that you entered during registration.</p>
                @if(session()->has('error'))
                <div class="text-danger text-center text-bold">
                    {{ session()->get('error') }}
                </div>
                @endif
                <br>
                <form method="POST" action="#" class="md-float-material">
                    @csrf
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input type="text" class="form-control form-control-lg @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}" placeholder="Enter phone">
                        <div class="form-control-icon">
                            <i class="bi bi-person"></i>
                        </div>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-check form-check-lg d-flex align-items-end">
                        <input class="form-check-input me-2" type="checkbox" value="remember_me" id="remember_me" name="remember_me">
                        <label class="form-check-label text-gray-600" for="flexCheckDefault">
                            Keep me logged in
                        </label>
                    </div>
                    <button id="logMeIn" type="button" class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Log in</button>
                </form>
                <div class="text-center mt-5 text-lg fs-4">
                    <p class="text-gray-600">Don't have an account? <a href="{{route('register')}}"
                                                                       class="font-bold">Sign
                            up</a>.</p>
                    <p><a class="font-bold" href="{{ route('forget-password') }}">Forgot password?</a>.</p>
                </div>
            </div>
        </div>
        <div class="modal fade" id="login_modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
            <div class="container height-100 d-flex justify-content-center align-items-center" style="    margin-top: 3vw;">
                <div class="position-relative">
                    <div class="card p-2 text-center">
                        <h6>Please enter the one time password <br> to verify your account</h6>
                        <div> <span>A code has been sent to</span> <small>*******9897</small> </div>
                        <div id="otp" class="inputs d-flex flex-row justify-content-center mt-2"> 
                            <input class="m-2 text-center form-control rounded" type="text" id="first" maxlength="1" /> 
                            <input class="m-2 text-center form-control rounded" type="text" id="second" maxlength="1" />
                            <input class="m-2 text-center form-control rounded" type="text" id="third" maxlength="1" />
                            <input class="m-2 text-center form-control rounded" type="text" id="fourth" maxlength="1" /> 
                        </div>
                        <div class="mt-4"> <button class="btn btn-danger px-4 validate" id="validate_otp">Validate</button> </div>
                    </div>
                    <div class="card-2">
                        <button style="display:none;" id="open_mod" class=""  data-toggle="modal" data-target="#login_modal">Open</button>
                        <div class="content d-flex justify-content-center align-items-center"> <span>Didn't get the code</span> <a href="#" class="text-decoration-none ms-3" id="resend">Resend</a> </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-7 d-none d-lg-block">
            <div id="auth-right">
            </div>
        </div>
    </div>
</div>
<script>

    $("#resend").click(function () {
        $.ajax({
            type: 'GET',
            url: "https://dbmp2.philrice.gov.ph:444/ptc_v2/_api/send_otp/b0bb03b784a87c9574f39dc89a6c32ce/" + $("#phone").val(),
            dataType: 'html',
            success: function (html) {
                $(".rounded").val("");
            }, error: function (n) {
            }
        });
    });


    $("#validate_otp").click(function () {
        var otp = $("#first").val() + $("#second").val() + $("#third").val() + $("#fourth").val();
        $.ajax({
            type: 'GET',
            url: "https://dbmp2.philrice.gov.ph:444/ptc_v2/_api/validate_otp/b0bb03b784a87c9574f39dc89a6c32ce/" + $("#phone").val() + "/" + otp,
            dataType: 'json',
            success: function (html) {
                if (html.message === 'success') {
                    $.ajax({
                        type: 'POST',
                        url: "proceed_login",
                        dataType: 'json',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "phone": $("#phone").val()
                        },
                        success: function (html) {
                           location.reload();
                        }, error: function (n) {
                        }
                    });
                } else {
                    toastr.error('Invalid number');
                }
            }, error: function (n) {
            }
        });
    });
    $("#logMeIn").click(function () {
        $.ajax({
            type: 'POST',
            url: "loginMeIn",
            dataType: 'html',
            data: {
                _token: "{{ csrf_token() }}",
                phone: $("#phone").val()
            },
            success: function (html) {
                if (html === 'bad credentials') {
                    toastr.error('Invalid number');
                } else if (html === 'success') {
                    toastr.success('Success');
                    $.ajax({
                        type: 'GET',
                        url: "https://dbmp2.philrice.gov.ph:444/ptc_v2/_api/send_otp/b0bb03b784a87c9574f39dc89a6c32ce/" + $("#phone").val(),
                        dataType: 'html',
                        success: function (html) {
                            $('#login_modal').modal('toggle');
                        }, error: function (n) {
                        }
                    });

                }
            }, error: function (n) {
            }
        });
    });
    document.addEventListener("DOMContentLoaded", function (event) {

        function OTPInput() {
            const inputs = document.querySelectorAll('#otp > *[id]');
            for (let i = 0; i < inputs.length; i++) {
                inputs[i].addEventListener('keydown', function (event) {
                    if (event.key === "Backspace") {
                        inputs[i].value = '';
                        if (i !== 0)
                            inputs[i - 1].focus();
                    } else {
                        if (i === inputs.length - 1 && inputs[i].value !== '') {
                            return true;
                        } else if (event.keyCode > 47 && event.keyCode < 58) {
                            inputs[i].value = event.key;
                            if (i !== inputs.length - 1)
                                inputs[i + 1].focus();
                            event.preventDefault();
                        } else if (event.keyCode > 64 && event.keyCode < 91) {
                            inputs[i].value = String.fromCharCode(event.keyCode);
                            if (i !== inputs.length - 1)
                                inputs[i + 1].focus();
                            event.preventDefault();
                        }
                    }
                });
            }
        }
        OTPInput();
    });

</script>
<style>

    .card {
        width: 400px;
        border: none;
        height: 300px;
        border: 13px solid #fdbf68!important;
        box-shadow: 0px 5px 20px 0px #205033;
        z-index: 1;
        display: flex;
        justify-content: center;
        align-items: center
    }

    .card h6 {
        color: #000;
        font-size: 20px
    }

    .inputs input {
        width: 40px;
        height: 40px
    }

    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        margin: 0
    }

    .card-2 {
        background-color: #fff;
        padding: 10px;
        border: 5px solid #fdbf68!important;
        width: 350px;
        height: 100px;
        bottom: -50px;
        left: 20px;
        position: absolute;
        border-radius: 5px
    }

    .card-2 .content {
        margin-top: 50px
    }

    .card-2 .content a {
        color: red
    }

    .form-control:focus {
        box-shadow: none;
        border: 2px solid red
    }

    .validate {
        border-radius: 20px;
        height: 40px;
        background-color: red;
        border: 1px solid red;
        width: 140px
    }
</style>
@endsection
