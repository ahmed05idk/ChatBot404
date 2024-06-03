@extends('auth.layout')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<div class="container">
    <div class="card" style="padding-bottom:0;">

        @if(session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif


        <div class="container-fluid">

            <div class="row" style="width: 50px;">
                <a href="/" class="back-button" style="">
                    <i class="fa fa-arrow-left"></i>
                </a>
            </div>
            <form method="POST" action="{{ route('login') }}">
                @csrf


                <div class="row" style="height: 20px; margin-bottom: 10px">

                    @if ($errors->any())
                    <i class='fas fa-exclamation-triangle' id="wrongPassMail"> Attenzione password o email errate</i>
                    @endif
                </div>




                <div class="row">
                    <div class="form-group">
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}"
                            required autocomplete="email" autofocus placeholder="Email">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <input id="password" type="password" class="form-control" name="password" required
                            autocomplete="current-password" placeholder="Password">
                    </div>
                </div>



                <div class="row">
                    <div class="form-group form-check">

                        <label class="form-check-label" for="remember" style="margin-bottom: 20px;">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                {{ old('remember') ? 'checked' : '' }}>
                            {{ __('Remember Me') }}
                        </label>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group mb-0">
                        <button type="submit" class="btn btn-primary" style="margin-bottom:20px">
                            {{ __('Login') }}
                        </button>
                    </div>
                    <div class="row" style="justify-content: center;">
                        @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}" style="width: 200px;">
                            {{ __('Forgot Your Password?') }}
                        </a>
                        @endif
                    </div>
                </div>
            </form>



        </div>


        <div class="row" style="text-align: center; justify-content: center;">
            <a href="/register" class="btn-link" style="text-decoration: none; text-align: center;"
                id="changeLogReg">Non hai un account?
                Registrati</a>
        </div>
    </div>
</div>
@endsection