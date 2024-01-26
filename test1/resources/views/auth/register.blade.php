@extends('auth.layout')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <div class="card-body">
                    @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif

                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <a href="/" class="back-button">
                        <i class="fa fa-arrow-left"></i>
                    </a>

                    <form method="POST" action="{{ route('register') }}" id="campi">
                        @csrf

                        <div class="form-group row">

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}"
                                    required autocomplete="name" placeholder="Name" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email"
                                    value="{{ old('email') }}" required autocomplete="email" placeholder="Email">
                            </div>
                        </div>

                        <div class="form-group row">

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required
                                    autocomplete="new-password" placeholder="Password">
                            </div>
                        </div>

                        <div class="form-group row">

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control"
                                    name="password_confirmation" required autocomplete="new-password"
                                    placeholder="Confirm Password">
                            </div>
                        </div>

                        <div id="verificationBox" class="form-group row mb-0">
                            <div id="verificationBoxInterno">
                                <input id="verification_code" type="text" class="form-control" name="verification_code"
                                    required placeholder="Codice di verifica">
                                <button type="button" class="btn btn-primary" id="sendVerificationCode"
                                    onclick="sendVerificationEmail()">
                                    Invia Codice
                                </button>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary" onclick="registrati()">
                                    Registrati
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
var verificationCode = '';

function sendVerificationEmail() {
    $.ajax({
        type: 'POST',
        url: '/sendVerificationEmail',
        data: {
            email: $('#email').val(),
            _token: '{{ csrf_token() }}'
        },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                console.log('Mail inviata con successo');
                verificationCode = response.verification_code;
                console.log('Codice di verifica: ' + verificationCode);
            } else {
                console.error('Errore durante l\'invio della mail');
            }
        },
        error: function(error) {
            console.error('Errore durante l\'invio della mail: ' + error);
        }
    });
}

function registrati() {
    // Ottieni il codice inserito dall'utente

    var enteredCode = $('#verification_code').val();
    
    if (enteredCode == verificationCode) {
        console.log('Codice di verifica corretto');

        return;
    } else {
        console.error('Codice di verifica errato');
        event.preventDefault();
    }
}
</script>

@endsection