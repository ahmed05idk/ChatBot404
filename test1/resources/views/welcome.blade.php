<!DOCTYPE html>
<html lang="it">

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f4;
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }

    #contenitore-chat {
        flex: 1;
        display: flex;
        overflow: hidden;
    }

    #barra-sinistra {
        min-width: 180px;
        width: 15%;
        background-color: #333;
        color: #fff;
        padding: 20px;
        overflow-y: auto;
        height: 100vh;
    }

    #barra-destra {
        flex: 3;
        display: flex;
        flex-direction: column;
        padding: 20px 20px 0px 20px;
        overflow-y: auto;
        height: 100vh;
        position: relative;
    }
    #barra-sopra {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        height: 30px;
        gap: 10px;
    }

    #elenco-chat {
        margin-bottom: 20px;
    }

    .chat-item {
        cursor: pointer;
        padding: 10px;
        margin-bottom: 5px;
        background-color: #2e8500;
        border-radius: 5px;
        margin: 0.5rem;
    }

    .chat {
        display: none;
    }

    .active-chat {
        display: block;
    }

    #chat-container {
        flex: 1;
        word-wrap: break-word;
    }

    #barra-invio {
        display: flex;
        position: sticky;
        bottom: 0;
        width: 100%;
        background-color: #fff;
        padding: 20px;
        box-sizing: border-box;
        z-index: 1000;
        align-items: flex-end;
        min-height: 9%;
    }


    #messaggio-input {
        width: 100%;
        padding: 10px;
        box-sizing: border-box;
        border: 1px solid #ccc;
        border-radius: 5px;
        resize: none;
        height: 88%;
        max-height: 200px;
        overflow-y: auto;
    }

    #invia-bottone {
        background-color: #4CAF50;
        color: white;
        border: none;
        cursor: pointer;
        margin-left: 10px;
        border-radius: 5px;
        height: 60px;
    }
    </style>
</head>

<body>
    <div id="contenitore-chat">
        <div id="barra-sinistra">
            <h2>Le Tue Chat</h2>
            <button onclick="creaNuovaChat()" style="margin: 0.5rem;">Nuova Chat</button>
            <div id="elenco-chat"></div>
        </div>
        <div id="barra-destra">
            <div id="barra-sopra">
                @if (Auth::check())
                <span class="nav-link" style="padding: 0.5rem;">Benvenuto: {{ Auth::user()->name }}</span>
                <div>
                    <a class="nav-link" href="{{ route('logout') }}" style="padding: 0.5rem;"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
                @else
                <a class="nav-link" href="{{ route('login') }}" style="padding: 0.5rem;">Login</a>
                <a class="nav-link" href="{{ route('register') }}" style="padding: 0.5rem;">Register</a>
                @endif
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    var chatCounter = 0;



    window.addEventListener('DOMContentLoaded', (event) => {
        const textarea = document.getElementById('messaggio-input');
        textarea.addEventListener('input', autoResize, false);


        textarea.addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                if (event.shiftKey) {
                    // Se Shift è premuto, vai a capo
                } else {
                    event.preventDefault();
                    inviaMessaggio();
                }
            }
        });

        // Ridimensionamento automatico della textareas
        function autoResize() {
            this.style.height = 'auto';
            if (this.scrollHeight > window.innerHeight * 0.1) {
                this.style.height = '10vh';
                this.style.overflowY = 'scroll';
            } else {
                this.style.height = this.scrollHeight + 'px';
                this.style.overflowY = 'hidden';
            }
        }
    });


    function creaNuovaChat() {
        var barraSinistra = document.getElementById('barra-sinistra');
        var nuovaChatDiv = document.createElement('div');
        var chatID = 'chat_' + chatCounter++;
        nuovaChatDiv.id = chatID;
        nuovaChatDiv.classList.add('chat-item');
        nuovaChatDiv.textContent = 'Nuova Chat ' + chatCounter;
        nuovaChatDiv.onclick = function() {
            cambiaChat(chatID);
        };
        barraSinistra.appendChild(nuovaChatDiv);
        document.getElementById('elenco-chat').appendChild(nuovaChatDiv);

        // Creazione del contenitore dei messaggi per questa chat
        var chatContainer = document.getElementById('chat-container');
        var nuovaChatContainer = document.createElement('div');
        nuovaChatContainer.id = chatID + '-container';
        nuovaChatContainer.classList.add('chat');
        chatContainer.appendChild(nuovaChatContainer);

        cambiaChat(chatID);
    }


    // Funzione per cambiare la chat attiva
    var messaggiPerChat = {};

    function cambiaChat(chatID) {
        // Nascondi tutti i contenitori delle chat
        var chatContainers = document.querySelectorAll('.chat');
        chatContainers.forEach(function(container) {
            container.classList.remove('active-chat');
        });

        // Mostra solo il contenitore della chat selezionata
        var chatContainer = document.getElementById(chatID + '-container');
        chatContainer.classList.add('active-chat');

        // Aggiorna l'intestazione con il nome della chat corrente
        document.getElementById('tua-chat-header').textContent = document.getElementById(chatID).textContent;

        // Ripristina il messaggio precedente per la chat corrente
        var inputMessaggio = document.getElementById('messaggio-input');
        inputMessaggio.value = messaggiPerChat[chatID] || '';
    }


    // Chiamare la funzione creaNuovaChat() per creare la chat iniziale
    creaNuovaChat();

    function inviaMessaggio() {
        var inputMessaggio = document.getElementById('messaggio-input');
        var messaggio = inputMessaggio.value;

        if (messaggio.trim() !== '') {
            var chatContainer = document.querySelector('.active-chat');
            chatContainer.innerHTML += '<p>Tu: ' + messaggio + '</p>';

            // Salva il messaggio per la chat corrente
            var chatID = chatContainer.id.replace('-container', '');
            messaggiPerChat[chatID] = messaggio;

            // Pulisci il contenuto del textarea e reimposta la sua altezza
            inputMessaggio.value = '';
            inputMessaggio.style.height = 'auto';
        }
    }
    </script>
</body>

</html>