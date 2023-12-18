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
        <div id="barra-sinistra">
            <h2>Le Tue Chat</h2>
            <button onclick="creaNuovaChat()" style="margin: 0.5rem;">Nuova Chat</button>
            <div id="elenco-chat"></div>
        </div>
        <div id="barra-destra">
            <div id="barra-sopra" style="display: flex; justify-content: space-between;">
                <div class="nav-link" style="padding: 0.5rem;">
                    @if (Auth::check())
                    <span>Benvenuto: {{ Auth::user()->name }}</span>
                    @endif
                </div>
                <div class="login-register">
                    @if (Auth::check())
                    <a class="nav-link" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    @else
                    <a href="{{ route('login') }}" class="nav-link" style="padding: 0.5rem;">Login</a>
                    <a href="{{ route('register') }}" class="nav-link" style="padding: 0.5rem;">Register</a>
                    @endif
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


</body>

</html>