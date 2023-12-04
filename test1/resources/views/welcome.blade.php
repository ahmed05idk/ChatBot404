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
            position: relative; /* Cambia a position: relative; */
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
        }


        #messaggio-input {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        #invia-bottone {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            margin-left: 10px;
            border-radius: 5px;
        }

    </style>
</head>
<body>
    <div id="contenitore-chat">
        <div id="barra-sinistra" >
            <h2>Le Tue Chat</h2>
            <button onclick="creaNuovaChat()" style="margin: 0.5rem;">Nuova Chat</button>
            <div id="elenco-chat"></div>
        </div>
        <div id="barra-destra">
            <div id="barra-sopra" style="height: 30px; text-align: right; display: flex; justify-content: end; gap: 10px;">
                <a class="nav-link" href="{{ route('login') }}" style="padding: 0.5rem;">Login</a>
                <a class="nav-link" href="{{ route('register') }}" style="padding: 0.5rem;">Register</a>
            </div>

            <h2 id="tua-chat-header">Chat</h2>
            <div id="chat-container"></div>

            <div id="barra-invio" >
                <input type="text" id="messaggio-input" placeholder="Scrivi il tuo messaggio...">
                <button id="invia-bottone" onclick="inviaMessaggio()" style="padding: 1rem;">
                    &#9650;
                </button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        var chatCounter = 0;

        function creaNuovaChat() {
        var barraSinistra = document.getElementById('barra-sinistra');
        var nuovaChatDiv = document.createElement('div');
        var chatID = 'chat_' + chatCounter++;
        nuovaChatDiv.id = chatID;
        nuovaChatDiv.classList.add('chat-item');
        nuovaChatDiv.textContent = 'Nuova Chat ' + chatCounter;
        nuovaChatDiv.onclick = function () {
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
    function cambiaChat(chatID) {
        // Nascondi tutti i contenitori delle chat
        var chatContainers = document.querySelectorAll('.chat');
        chatContainers.forEach(function (container) {
            container.classList.remove('active-chat');
        });

        // Mostra solo il contenitore della chat selezionata
        var chatContainer = document.getElementById(chatID + '-container');
        chatContainer.classList.add('active-chat');

        document.getElementById('tua-chat-header').textContent = document.getElementById(chatID).textContent;
    }

    // Chiamare la funzione creaNuovaChat() per creare la chat iniziale
    creaNuovaChat();

        function inviaMessaggio() {
            var inputMessaggio = document.getElementById('messaggio-input');
            var messaggio = inputMessaggio.value;

            if (messaggio.trim() !== '') {
                var chatContainer = document.querySelector('.active-chat');
                chatContainer.innerHTML += '<p>Tu: ' + messaggio + '</p>';
                inputMessaggio.value = '';
            }
        }
    </script>
</body>
</html>
