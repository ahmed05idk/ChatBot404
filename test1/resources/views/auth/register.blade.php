@extends('auth.layout')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">

                <div class="card-body">

                    <div class="row" style="height: 40px;width: 50px;">
                        <a href="/" class="back-button">
                            <i class="fa fa-arrow-left"></i>
                        </a>
                    </div>
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <div class="row" style="height: 20px; margin-bottom: 10px">
                        <div id="errore" style="color:red; text-align:center;"></div>
                        <div id="successo" style="color:green; text-align:center;"></div>

                    </div>

                    <form method="POST" action="{{ route('register') }}" id="campi">
                        @csrf

                        <div class="form-group row">

                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}"
                                required autocomplete="name" placeholder="Name" autofocus>

                        </div>

                        <div class="container-fluid" style="padding: 0 !important">
                            <div class="form-group row">

                                <div class="col emailAndVer">
                                    <input id="email" type="email" class="form-control" name="email"
                                        value="{{ old('email') }}" required autocomplete="email" placeholder="Email">
                                </div>
                                <div class="col-4 emailAndVer">
                                    <button type="button" class="btn btn-primary" id="sendVerificationCode"
                                        onclick="sendVerificationEmail()">
                                        Invia Codice
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <input id="password" type="password" class="form-control" name="password" required
                                autocomplete="new-password" placeholder="Password">

                        </div>

                        <div class="form-group row">


                            <input id="password-confirm" type="password" class="form-control"
                                name="password_confirmation" required autocomplete="new-password"
                                placeholder="Confirm Password">

                        </div>

                        <div id="verificationBox" class="form-group row">
                            <input id="verification_code" type="text" class="form-control" name="verification_code"
                                required placeholder="Codice di verifica"
                                onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                        </div>


                        <div class="form-group row">
                            <button type="submit" class="btn btn-primary" onclick="registrati()">
                                Registrati
                            </button>
                        </div>
                    </form>
                </div>
                <div class="row" style="text-align: center;  padding-top:10px">
                    <a href="/register" class="btn-link" style="text-decoration: none; text-align: center;"
                        id="changeLogReg">Hai già un account? Accedi</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
var verificationCode; // Dichiarazione globale


/**
 * Metodo per inviare l'email di verifica
 * 
 * @returns void in caso la mail non sia valida
 *
 * @author Ethan
 */
function sendVerificationEmail() {
    var email = $('#email').val();

    // Verifica se l'email è valida utilizzando un'espressione regolare
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        document.getElementById('successo').innerHTML = "";
        document.getElementById('errore').innerHTML = "<i class='fas fa-exclamation-triangle'></i>" +
            " Email non valida";
        return; // Esce dalla funzione se l'email non è valida
    }
    document.getElementById('errore').innerHTML = "";
    document.getElementById('successo').innerHTML = "&#10004 Email inviata con successo!";

    $.ajax({
        type: 'POST',
        url: '/sendVerificationEmail',
        data: {
            email: email,
            _token: '{{ csrf_token() }}'
        },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                verificationCode = response.verification_code; // Assegna il valore di verificationCode

            } else {}
        },
        error: function(error) {
            console.error('Errore durante l\'invio della mail: ' + error);
        }
    });
}


/**
 * Metodo che controlla se il codice iserito è uguale a quello generato se no bloccca l'evento principale
 * 
 * @returns void in caso il codice sia corretto
 *
 * @author Ethan
 */
function registrati() {
    var enteredCode = $('#verification_code').val();



    if (verificationCode == enteredCode) {
        document.getElementById('errore').innerHTML = "";
        return;
    } else {
        document.getElementById('successo').innerHTML = "";
        document.getElementById('errore').innerHTML = "<i class='fas fa-exclamation-triangle'></i> " +
            " Codice di verifica errato!";
        event.preventDefault();
    }
}
</script>

@endsection