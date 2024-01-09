<!-- resources/views/homeJS.blade.php -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> -->

</head>

<body>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
    var chatCounter = 1;

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





    window.onload = function() {
    var initialChatID = 'chat_1'; // replace this with the ID of the chat you want to select
    cambiaChat(initialChatID);
    
};
console.log("a");
creaChatDaDB();

function creaChatDaDB() {
    var messaggi = <?php echo json_encode($messaggi); ?>;
    if (messaggi.length === 0) {
        creaNuovaChat();
        return;
    }

    // Crea un array di ID di chat unici
    var chatIDs = [];
    messaggi.forEach(function(messaggio) {
        if (!chatIDs.includes(messaggio.ChatID)) {
            chatIDs.push(messaggio.ChatID);
        }
    });

    // Crea una nuova chat per ogni ID di chat unico
    chatIDs.forEach(function(chatID) {
        creaNuovaChat(chatID);
    });

    // Assegna i messaggi alle chat corrispondenti
    messaggi.forEach(function(messaggio) {
        document.getElementById(messaggio.ChatID+'-container').innerHTML = messaggio.message;
    });
}



 

function creaNuovaChat() {
    var barraSinistra = document.getElementById('barra-sinistra');
    var nuovaChatDiv = document.createElement('div');
    var chatID = 'chat_' + chatCounter; // removed the increment here
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

    chatCounter++; // keep the increment here
    
}
   // Chiamare la funzione creaNuovaChat() per creare la chat iniziale
   



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


    function inviaMessaggio() {
        var inputMessaggio = document.getElementById('messaggio-input');
        var messaggio = inputMessaggio.value;

        if (messaggio.trim() !== '') {
            var chatContainer = document.querySelector('.active-chat');

            // Effettua una richiesta AJAX per salvare il messaggio nel database


            // Aggiungi il messaggio alla chat solo se il salvataggio nel database è riuscito
            chatContainer.innerHTML += '<p>Tu: ' + messaggio + '</p>';

            // Pulisci il contenuto del textarea e reimposta la sua altezza
            inputMessaggio.value = '';
            inputMessaggio.style.height = 'auto';

        }
    }


    window.onbeforeunload = function() {

        var isUserRegistered = checkUserRegistration();

        if (isUserRegistered) {

            salvaDatiSincronamente();
        }


        return null

    };

    function salvaDatiSincronamente() {
        var chatContainers = document.querySelectorAll('[id^="chat_"][id$="-container"]');

        // Itera attraverso i contenitori delle chat e salva il loro contenuto nel database
        chatContainers.forEach(function(container) {
            var chatID = container.id.replace('-container', ''); // Ottieni l'ID della chat
            var messages = container.innerHTML; // Ottieni il contenuto del container

            // Ottieni l'ID dell'utente lato server usando PHP
            var idUtente = <?php if(Auth::check()) { echo Auth::user()->id; } else { echo 'null'; } ?>;

            // Invia una richiesta AJAX per salvare il contenuto nel database
            salvaChatNelDatabase(chatID, messages, idUtente)
                .then(function() {
                    console.log('Chat salvata con successo nel database.');
                })
                .catch(function(error) {
                    console.error('Errore nel salvataggio della chat:', error);
                    if (error.response) {
                        console.error('Dettagli dell\'errore:', error.response.data);
                    }
                });
        });
    }


    function salvaChatNelDatabase(chatID, messages, idUtente) {
        return axios.post('/messages', {
            chatID: chatID,
            message: messages,
            userCreationId: idUtente
        });
    }

    function checkUserRegistration() {
        @if(Auth::check())
        return true
        @else
        return false
        @endif
    }



    </script>
</body>

</html>