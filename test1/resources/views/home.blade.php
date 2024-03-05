<!DOCTYPE html>
<html lang="it">

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    @extends('homeStyle')
    @extends('homeJs')
</head>

<body>
    <div id="contenitore-chat">
        <div id="barra-sinistra" class="aperta">
            <h2>Le Tue Chat</h2>
            <button onclick="creaNuovaChat(false); cambiaChatAllaCreazione();"
                style="margin: 0.5rem;">NuovaChat</button>
            <div id="elenco-chat"></div>
        </div>

        <button id="freccia" class='fas fa-angle-left' style='font-size:36px' onclick="chiudiBarraSinistra()"></button>

        <div id="barra-destra">
            <div id="barra-sopra" style="display: flex; justify-content: space-between;">
                <div class="nav-link" style="padding: 0.5rem;">
                    @if (Auth::check())
                    <span>Benvenuto: {{ Auth::user()->name }}</span>
                    @endif
                </div>

                <div class="login-register">
                    <span onclick="toggleOptions()" style="cursor: pointer; ">Opzioni</span>
                    <div id="opzioni">
                        @if (Auth::check())
                        <a class="nav-link opzione" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        @else
                        <a href="{{ route('login') }}" class="nav-link opzione">Login</a>
                        <a href="{{ route('register') }}" class="nav-link opzione">Register</a>
                        @endif
                        <div class="nav-link opzione" onclick="mostraPopupSvuotaChat()">Elimina tutte le chat</div>
                        <div class="nav-link opzione"></div><!-- inserire così opzioni -->
                    </div>
                </div>
            </div>

            <h2 id="tua-chat-header">Chat</h2>
            <div id="chat-container"></div>

            <div id="barra-invio">
                <textarea type="text" id="messaggio-input" placeholder="Scrivi il tuo messaggio..."></textarea>
                <button id="invia-bottone" onclick="inviaMessaggio()" style="padding: 1rem;">
                    &#9650;
                </button>
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