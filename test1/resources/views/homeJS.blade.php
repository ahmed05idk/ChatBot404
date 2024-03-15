<!-- resources/views/homeJS.blade.php -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> -->

</head>

<body>




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
        var createNewChat = true;

        if (!chatIDPassato) {
            if (daEliminare !== "EliminaUnicaChat") {
                var contenuto = document.getElementById(ultimaChatCreata + '-container');
                if (contenuto && !contenuto.innerHTML) {
                    createNewChat = false;
                }
            }
        }

        if (createNewChat) {
            var barraSinistra = document.getElementById('barra-sinistra');
            var nuovaChatDiv = document.createElement('div');
            var chatID;
            if (chatIDPassato) {
                chatID = chatIDPassato;
            } else {
                chatID = 'chat_' + chatCounter;
            }
            nuovaChatDiv.id = chatID;
            nuovaChatDiv.classList.add('chat-item');
            nuovaChatDiv.innerHTML = '<div style="display: flex; justify-content: space-between;">' +
                '<span>Nome chat generata ' + chatCounter + '</span>' +
                '<button class="chatButton" onclick="eliminaChat(event, \'' + chatID +
                '\')"><i class="fas fa-trash-alt"></i></button></div>';
            nuovaChatDiv.onclick = function() {
                cambiaChat(chatID);
            };

            var elencoChat = document.getElementById('elenco-chat');
            if (elencoChat.firstChild) {
                elencoChat.insertBefore(nuovaChatDiv, elencoChat.firstChild);
            } else {
                elencoChat.appendChild(nuovaChatDiv);
            }

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

    function chatPiuGrande() {
        var chatContainer = document.getElementById('chat-container');
        var divs = chatContainer.getElementsByTagName('div');
        var maxId = 0;
        var maxIdNumber = 0;

        for (var i = 0; i < divs.length; i++) {
            var divId = divs[i].id;
            if (divId.startsWith('chat_')) {
                var idNumber = parseInt(divId.split('_')[1]);
                if (idNumber > maxIdNumber) {
                    maxIdNumber = idNumber;
                    maxId = idNumber;
                }
            }
        }
        return 'chat_' + maxId;
    }


    function eliminaChat(event, chatID) {
        // Impedisci la propagazione dell'evento al pulsante principale
        if (event) {
            event.stopPropagation();
        }
        contenuto = document.getElementById(ultimaChatCreata + '-container');

        var elencoChat = document.getElementById('elenco-chat');
        var numeroDiDivFigli = elencoChat.childElementCount;

        // Mostra il popup
        document.getElementById('overlay').style.display = 'flex';

        var confermaBtn = document.getElementById('conferma-btn');
        var annullaBtn = document.getElementById('annulla-btn');


        confermaBtn.addEventListener('click', function confermaClick() {

            if (numeroDiDivFigli == 1) {
                creaNuovaChat("", "EliminaUnicaChat");
                cambiaChat(ultimaChatCreata);
            }

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

                    cambiaChat(chatPiuGrande());

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
            //document.getElementById('tua-chat-header').textContent = document.getElementById(chatID).textContent;

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
        var freccia = document.getElementById('freccia');

        if (larghezzaFinestra < 800) {
            barraSinistra.classList.add('chiudi');
            freccia.classList.add('chiusa');
        } else {
            barraSinistra.classList.remove('chiudi');
            freccia.classList.remove('chiusa');


        }
    }

    // Aggiungi un ascoltatore di eventi per l'evento resize della finestra
    window.addEventListener('resize', controllaDimensioniFinestra);

    // Chiama la funzione all'inizio per controllare le dimensioni iniziali della finestra
    controllaDimensioniFinestra();


    document.addEventListener('click', function(event) {
        var optionsDiv = document.getElementById("opzioni");
        var targetElement = event.target;

        // Controllo se il clic è avvenuto all'interno dell'elemento #opzioni
        var isClickInsideOptions = optionsDiv.contains(targetElement);

        // Se il clic è al di fuori di #opzioni e #opzioni è attiva, chiudo le opzioni
        if (!isClickInsideOptions && optionsDiv.classList.contains("active")) {
            optionsDiv.classList.remove("active");
        }
    });

    // Funzione per gestire il clic sull'opzione di toggle
    function toggleOptions(event) {
        event
            .stopPropagation(); // Impedire la propagazione del clic per evitare che venga gestito dal document click listener
        var optionsDiv = document.getElementById("opzioni");
        optionsDiv.classList.toggle("active");
    }


    function mostraPopupSvuotaChat() {
        document.getElementById('overlay2').style.display = 'flex';

    }

    function chiudiPopup2() {
        document.getElementById('overlay2').style.display = 'none';
    }

    function svuotaChat() {

        var elencoChat = document.getElementById("elenco-chat");

        // Inizializza un array per salvare gli ID dei figli
        var chatDaEliminare = [];

        // Se l'elemento genitore esiste
        if (elencoChat) {
            // Seleziona tutti i figli che hanno un id che inizia con "chat_"
            var figli = elencoChat.querySelectorAll("[id^='chat_']");

            // Itera attraverso tutti i figli e salva i loro ID nell'array
            figli.forEach(function(figlio) {
                chatDaEliminare.push(figlio.id);
            });
        }

        for (var i = 0; i < chatDaEliminare.length; i++) {
            (function(i) { // Blocco funzione per catturare il valore corrente di i
                $.ajax({
                    type: 'POST',
                    url: '/deleteChat',
                    data: {
                        chatId: chatDaEliminare[i],
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        // Rimuovi la chat dallo schermo
                        var chatDiv = document.getElementById(chatDaEliminare[i]);
                        if (chatDiv) {
                            chatDiv.remove();
                        }

                        // Rimuovi anche il contenitore dei messaggi della chat
                        var chatContainer = document.getElementById(chatDaEliminare[i] + '-container');
                        if (chatContainer) {
                            chatContainer.remove();
                        }

                    },
                    error: function(error) {
                        console.error('Errore durante l\'aggiornamento del messaggio');
                    }
                });
            })(i); // Invocazione immediata del blocco funzione
        }

        document.getElementById('overlay2').style.display = 'none';
        creaNuovaChat("", "EliminaUnicaChat");
        cambiaChat(ultimaChatCreata);
    }


    selectFirstChat();
    </script>
</body>

</html>