@extends('backend.auth.auth_master')

@section('auth_title')
    Login |  Dashoard
@endsection

@section('auth-content')
     <!-- login area start -->
     <div class="login-area">
        <div class="container">
            <div class="login-box ptb--100">
                <form method="POST" action="{{ route('authenticate') }}">
                    @csrf
                    <div class="login-form-head">
                        <h4>Sign In /
</h4>

                        <p>Hello there, Sign in and start managing user</p>
                    </div>

                    <div class="login-form-body">
                        @include('backend.layouts.partials.messages')
                        <div class="form-gp">
                            <label for="exampleInputEmail1">Email address or Username</label>
                            <input type="text" id="exampleInputEmail1" class=" @error('email') is-invalid @enderror"  name="email" value="{{ old('email') }}">
                            <i class="ti-email"></i>
                            <div class="text-danger"></div>
                            @if ($errors->has('email'))
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                        <div class="form-gp">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" id="exampleInputPassword1" class="@error('password') is-invalid @enderror" name="password">
                            <i class="ti-lock"></i>
                            <div class="text-danger"></div>
                            @if ($errors->has('password'))
                            <span class="text-danger">{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                        <div class="row mb-4 rmber-area">
                            <div class="col-6">
                                <div class="custom-control custom-checkbox mr-sm-2">
                                    <input type="checkbox" class="custom-control-input" id="customControlAutosizing" name="remember">
                                    <label class="custom-control-label" for="customControlAutosizing">Remember Me</label>
                                </div>
                            </div>
                            {{-- <div class="col-6 text-right">
                                <a href="#">Forgot Password?</a>
                            </div> --}}
                        </div>
                        <div class="submit-btn-area">
                            <button id="form_submit" type="submit">Sign In <i class="ti-arrow-right"></i></button>

                        </div>
                         <a  href="{{ route('register') }}">Click Here For Register</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- login area end -->
@endsection