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
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <script>
    var chatCounter = 1;
    var chatModificate = [];
    var ultimaChatCreata = "chat_1";


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





    function selectFirstChat() {

        if (checkUserRegistration()) {
            var messaggi = <?php echo json_encode($messaggi); ?>;

            if (messaggi.length == 0) {
                initialChatID = 'chat_1';
            } else {
                var initialChatID = messaggi[0].ChatID;
            }


            cambiaChat(initialChatID);
            return;
        }
        cambiaChat('chat_1');
    };

    creaChatDaDB();

    function creaChatDaDB() {
        var messaggi = <?php echo json_encode($messaggi); ?>;
        if (messaggi.length == 0) {
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
            document.getElementById(messaggio.ChatID + '-container').innerHTML = messaggio.message;
        });

    }


    function creaNuovaChat(chatIDPassato, daEliminare) {
        createNewChat = true;

        if (!chatIDPassato) {
            if (daEliminare !== "EliminaUnicaChat") {
            contenuto = document.getElementById(ultimaChatCreata + '-container');
            if (contenuto) {
                if (!contenuto.innerHTML) {
                    createNewChat = false;
                }
            }
        }
    }
    

    if (createNewChat) {
        console.log("S")
        var barraSinistra = document.getElementById('barra-sinistra');
        var nuovaChatDiv = document.createElement('div');
        if (chatIDPassato) {
            var chatID = chatIDPassato;
        } else {
            var chatID = 'chat_' + chatCounter;
        }
        nuovaChatDiv.id = chatID;

        nuovaChatDiv.classList.add('chat-item');
        nuovaChatDiv.innerHTML = 'Nuova Chat ' + chatCounter +
            '<button class="chatButton" onclick="eliminaChat(event, \'' + chatID +
            '\')"><i class="fas fa-trash-alt"></i></button>';

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


        chatCounter++;
        ultimaChatCreata = chatID;
    }
    }


    function cambiaChatAllaCreazione() {
        var chatID = 'chat_' + (chatCounter - 1);
        cambiaChat(chatID);
    }
    /*
        function eliminaChat(event, chatID) {
            // Impedisci la propagazione dell'evento al pulsante principale
            event.stopPropagation();


            contenuto = document.getElementById(ultimaChatCreata + '-container');

            var elencoChat = document.getElementById('elenco-chat');
            var numeroDiDivFigli = elencoChat.childElementCount;

            if (numeroDiDivFigli == 1) {

                creaNuovaChat();
            }
            if (numeroDiDivFigli != 1 || contenuto.innerHTML) {
                $.ajax({
                    type: 'POST',
                    url: '/deleteChat',
                    data: {
                        chatId: chatID,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        // Rimuovi la chat dallo schermo
                        var chatDiv = document.getElementById(chatID);
                        if (chatDiv) {
                            chatDiv.remove();
                        }

                        // Rimuovi anche il contenitore dei messaggi della chat
                        var chatContainer = document.getElementById(chatID + '-container');
                        if (chatContainer) {
                            chatContainer.remove();
                        }
                    },
                    error: function(error) {
                        console.error('Errore durante l\'aggiornamento del messaggio');
                    }
                });
            }

        }*/

    function eliminaChat(event, chatID) {
        // Impedisci la propagazione dell'evento al pulsante principale
        event.stopPropagation();

        contenuto = document.getElementById(ultimaChatCreata + '-container');

        var elencoChat = document.getElementById('elenco-chat');
        var numeroDiDivFigli = elencoChat.childElementCount;

        // Mostra il popup
        document.getElementById('overlay').style.display = 'flex';

        var confermaBtn = document.getElementById('conferma-btn');
        var annullaBtn = document.getElementById('annulla-btn');

        
        confermaBtn.addEventListener('click', function confermaClick() {
            //if (contenuto.innerHTML) {
                console.log(numeroDiDivFigli)
                if (numeroDiDivFigli == 1) {
                    creaNuovaChat("","EliminaUnicaChat");
                    cambiaChat(ultimaChatCreata);
                }
            //}

            //if (numeroDiDivFigli != 1 || contenuto.innerHTML) {
                $.ajax({
                    type: 'POST',
                    url: '/deleteChat',
                    data: {
                        chatId: chatID,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        // Rimuovi la chat dallo schermo
                        var chatDiv = document.getElementById(chatID);
                        if (chatDiv) {
                            chatDiv.remove();
                        }

                        // Rimuovi anche il contenitore dei messaggi della chat
                        var chatContainer = document.getElementById(chatID + '-container');
                        if (chatContainer) {
                            chatContainer.remove();
                        }
                        document.getElementById('overlay').style.display = 'none';

                        // Rimuovi l'event listener dopo l'esecuzione
                        confermaBtn.removeEventListener('click', confermaClick);
                    },
                    error: function(error) {
                        console.error('Errore durante l\'aggiornamento del messaggio');
                    }
                });
            //}
        });

        annullaBtn.addEventListener('click', function annullaClick() {
            // Nascondi il popup senza eliminare la chat
            document.getElementById('overlay').style.display = 'none';

            // Rimuovi l'event listener dopo l'esecuzione
            annullaBtn.removeEventListener('click', annullaClick);
        });
    }



    // Funzione per cambiare la chat attiva
    var messaggiPerChat = {};

    function cambiaChat(chatID) {
        var element = document.getElementById(chatID);
        if (element) {
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
}



    function inviaMessaggio() {

        var inputMessaggio = document.getElementById('messaggio-input');


        var messaggio = inputMessaggio.value;

        messaggio = String(messaggio).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g,
            '&quot;');




        if (messaggio.trim() !== '') {
            var chatContainer = document.querySelector('.active-chat');

            // Effettua una richiesta AJAX per salvare il messaggio nel database


            // Aggiungi il messaggio alla chat solo se il salvataggio nel database è riuscito
            chatContainer.innerHTML += '<p>Tu: ' + messaggio + '</p>';

            // Pulisci il contenuto del textarea e reimposta la sua altezza
            inputMessaggio.value = '';
            inputMessaggio.style.height = 'auto';

        }
        // Salva chat modificata per update
        if (!chatModificate.includes(chatContainer.id)) {
            chatModificate.push(chatContainer.id)
        }
    }


    window.onbeforeunload = function() {

        var isUserRegistered = checkUserRegistration();

        if (isUserRegistered) {

            salvaDatiSincronamente();

            updateChat();
        }


        return null

    };

    function salvaDatiSincronamente() {
        var chatContainers = document.querySelectorAll('[id^="chat_"][id$="-container"]');

        // Itera attraverso i contenitori delle chat e salva il loro contenuto nel database
        chatContainers.forEach(function(container) {
            var chatID = container.id.replace('-container', ''); // Ottieni l'ID della chat
            var messages = container.innerHTML; // Ottieni il contenuto del container
            var idExist = false;

            // controllo per evitare dupicati di chat nel db
            var messaggi = <?php echo json_encode($messaggi); ?>;
            var chatIDs = [];
            messaggi.forEach(function(messaggio) {
                if (!chatIDs.includes(messaggio.ChatID)) {
                    chatIDs.push(messaggio.ChatID);
                }
            });
            chatIDs.forEach(function(chatIDdb) {
                if (chatIDdb == chatID) {
                    idExist = true
                }

            });

            if (idExist) {
                return;
            }

            // Ottieni l'ID dell'utente lato server usando PHP
            var idUtente = <?php echo json_encode(Auth::check() ? Auth::user()->id : null); ?>;

            // Invia una richiesta AJAX per salvare il contenuto nel database
            if (messages) {
                salvaChatNelDatabase(chatID, messages, idUtente)
                    .then(function() {})
                    .catch(function(error) {
                        console.error('Errore nel salvataggio della chat:', error);
                        if (error.response) {
                            console.error('Dettagli dell\'errore:', error.response.data);
                        }
                    });
            }
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

    function updateChat() {
        for (var i = 0; i < chatModificate.length; i++) {
            var chatContainer = document.getElementById(chatModificate[i]);
            var newMessage = chatContainer.innerHTML;
            var chatId = chatContainer.id.replace('-container', '');

            $.ajax({
                type: 'POST',
                url: '/updateMessages',
                data: {
                    newMessage: newMessage,
                    chatId: chatId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    // Puoi gestire la risposta qui se necessario
                    console.log('Messaggio aggiornato con successo');
                },
                error: function(error) {
                    console.error('Errore durante l\'aggiornamento del messaggio');
                }
            });

        }
    }

    function chiudiBarraSinistra() {
    var barraSinistra = document.getElementById('barra-sinistra');
    var freccia = document.getElementById('freccia');
    barraSinistra.classList.toggle('chiudi'); // Aggiungi o rimuovi la classe 'chiudi'
    freccia.classList.toggle('chiusa'); // Aggiungi o rimuovi la classe 'chiusa' alla freccia
}


    function controllaDimensioniFinestra() {
            var larghezzaFinestra = window.innerWidth;
            var barraSinistra = document.getElementById('barra-sinistra');

            if (larghezzaFinestra < 500) {
                barraSinistra.classList.add('chiudi');
            } else {
                barraSinistra.classList.remove('chiudi');
            }
        }

        // Aggiungi un ascoltatore di eventi per l'evento resize della finestra
        window.addEventListener('resize', controllaDimensioniFinestra);

        // Chiama la funzione all'inizio per controllare le dimensioni iniziali della finestra
        controllaDimensioniFinestra();



        function toggleOptions() {
        var optionsDiv = document.getElementById("opzioni");
        if (optionsDiv.style.display === "none") {
            optionsDiv.style.display = "block";
        } else {
            optionsDiv.style.display = "none";
        }
    }





















    selectFirstChat();
    </script>
</body>

</html>