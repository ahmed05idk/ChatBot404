<!DOCTYPE html>
<html lang="it">

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    @extends('homeStyle')
    @extends('homeJs')

</head>

<body>

    <div class="container-fluid" id="containerPrincipale">
        <div class="row" id="rigaPrincipale">
            <div class="col-1" id="barra-sinistra">
                <div id="boxTitleCreateChat">
                    <h2>Le Tue Chat</h2>
                    <button onclick="creaNuovaChat(false); cambiaChatAllaCreazione();" id="pulsanteNuovaChat"
                        class="btn btn-success" style="margin: 0.5rem;">Crea Nuova Chat</button>
                </div>
                <div id="elenco-chat"></div>
            </div>

            <button id="freccia" class='fas fa-angle-left' style='font-size:36px'
                onclick="chiudiBarraSinistra()"></button>

            <div class="col" id="barra-destra">
                <div class="row" id="barra-sopra">
                    <div class="col">
                        @if (Auth::check())
                        <span>Benvenuto: {{ Auth::user()->name }}</span>
                        @endif
                    </div>
                    <div class="col" style="text-align: right;">
                        <div class="login-register">
                            <span onclick="toggleOptions(event)" style="cursor: pointer; ">Opzioni <i
                                    class="fa-solid fa-gear"></i></span>

                            <div id="opzioni">
                                @if (Auth::check())
                                <a class="nav-link opzione" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                                @else
                                <a href="{{ route('login') }}" class="nav-link opzione">Login</a>
                                <a href="{{ route('register') }}" class="nav-link opzione">Register</a>
                                @endif
                                <div class="nav-link opzione" onclick="mostraPopupSvuotaChat()">Elimina tutte le chat
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <h2 id="-chat-header">Tipologia bot scelto es: matematica</h2>

                <div class="row">
                    <div class="col-2">
                    </div>
                    <div class="col-8" id="chat-container">
                        <div id="barra-invio">
                            <div style="display: flex; align-items: flex-end;">
                                <textarea type="text" id="messaggio-input"
                                    placeholder="Scrivi il tuo messaggio..."></textarea>
                                <button id="invia-bottone" onclick="inviaMessaggio()" style="padding: 1rem;">
                                    &#9650;
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-2">
                    </div>
                </div>

                
            </div>
        </div>
    </div>
    <div class="overlay overlayPopup" id="overlay">
        <div class="popup">
            <h2>Eliminazione Chat</h2>
            <p>Confermi l'eliminazione di questa chat?</p>
            <div class="btn-container">
                <button id="conferma-btn" class="confirm-btn">Conferma</button>
                <button id="annulla-btn" class="cancel-btn">Annulla</button>
            </div>
        </div>
    </div>

    <div class="overlay2 overlayPopup" id="overlay2">
        <div class="popup">
            <h2>Eliminazione di tutte le chat</h2>
            <p>Vuoi procedere ed eliminare tutte le chat</p>
            <div class="btn-container">
                <button id="conferma-btn" class="confirm-btn" onclick="svuotaChat()">Conferma</button>
                <button id="annulla-btn" class="cancel-btn" onclick="chiudiPopup2()">Annulla</button>
            </div>
        </div>
    </div>

</body>

</html>