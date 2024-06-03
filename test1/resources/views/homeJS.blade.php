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

        var messaggiPerChat = {};

        /**
         * Questo metodo viene eseguito quando il contenuto della finestra viene caricato e serve a far si che se mentre scrivi in messaggio-input il testo vada a capo se si sta premendo shift
         *
         * @param event - L'evento di caricamento della finestra.
         * 
         * @author Ethan
         */
        window.addEventListener('DOMContentLoaded', (event) => {
            const textarea = document.getElementById('messaggio-input');
            //textarea.addEventListener('input', autoResize, false);

            $('#barra-destra').animate({
                scrollTop: $('#barra-destra').prop("scrollHeight")
            }, 'fast');

            textarea.addEventListener('keydown', function (event) {
                if (event.key === 'Enter') {
                    if (event.shiftKey) {
                        // se shift è premuto va a capo
                    } else {
                        event.preventDefault();
                        inviaMessaggio();
                    }
                }
            });
        });



        /**
         * Questo metodo serve a far ingrandire il campo di input messaggio-input quando il testo va a capo e a spostare il testo di chat-container più in alto
         *
         * @author Ethan
         */
        function autoResize() {
            var textarea = $(this);
            textarea.css('height', 'auto');
            var maxHeight = 150;
            var scrollHeight = textarea[0].scrollHeight;


            if (scrollHeight > maxHeight) {
                textarea.css('height', maxHeight + 'px');
                textarea.css('overflowY', 'scroll');

            } else {
                textarea.css('height', scrollHeight + 'px');
                textarea.css('overflowY', 'hidden');
            }
            var marginMap = {
                68: '40px',
                92: '60px',
                116: '80px',
                140: '100px',
                164: '120px',
            };

            if (scrollHeight === undefined) {
                scrollHeight = 68;
            } else if (scrollHeight > 164) {
                scrollHeight = 164;
            } else if (scrollHeight < 68) {
                scrollHeight = 68;
            };

            var margin = marginMap[scrollHeight];
            if (margin) {
                $('#chat-container').css('margin-bottom', margin);
            }

            $('#barra-destra').animate({
                scrollTop: $('#barra-destra').prop("scrollHeight")
            }, 'fast');
        }




        /**
         * Questo metodo serve a controllare se la finestra e cambiare chat in caso l'utente non sia registrato
         *
         * @author Ethan
         */
        $(document).ready(function () {

            aggiornaLarghezzaBarraInvio();

            if (!checkUserRegistration()) {

                cambiaChat('chat_1');

            } /*
            else {
                var primoElemento = document.querySelector('#elenco-chat > :first-child');
                cambiaChat(primoElemento.id);
            }*/

        });


        /**
         * Questo metodo va a creare le chat dal database se l'utente ha un account inserendo anche i messaggi e il nome della chat
         *
         * Il metodo viene runnato solo quando si carica il sito
         * 
         * @author Ethan
         */
        function creaChatDaDB() {
            if (!checkUserRegistration()) {
                creaNuovaChat();
                return;
            }
            var messaggi = <?php echo json_encode($messaggi); ?>;

            if (messaggi.length == 0) {
                creaNuovaChat();
                return;
            }

            var chatIDs = [];
            messaggi.forEach(function (messaggio) {

                if (!chatIDs.includes(messaggio.ChatID)) {
                    chatIDs.push(messaggio.ChatID);

                }
            });


            // crea una chat pper ogni chatID
            chatIDs.forEach(function (chatID) {

                creaNuovaChat(chatID);
            });

            // popopla le chat con i messaggi e il nome
            messaggi.forEach(function (messaggio) {
                var chatContainer = document.getElementById(messaggio.ChatID + '-container');

                chatContainer.innerHTML = messaggio.message;

                chatContainer.setAttribute('data-sys-prompt', messaggio.systemPrompt);

                document.querySelector("#" + messaggio.ChatID + " div span").innerHTML = messaggio.nomeChat;

            });
            putOnTop(0, true)

        }
        creaChatDaDB();




        /**
         * Questo metodo cambia il valore di ultimaChatCreata e chatCounter in base alle chat che vengono create dal db
         *
         * Il metodo viene runnato solo quando si carica il sito
         * 
         * @author Ethan
         */
        function updateUltimaChatCreata() {
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

            ultimaChatCreata = 'chat_' + maxId;

            chatCounter = maxId + 1;

        }
        updateUltimaChatCreata();



        var systemPrompt;

        /**
         * Questo metodo serve a creare una nuova chat quando si schiaccia sul pulsante crea nuova chat o se si elimina l'unica chat esistente.
         * In caso si cerchi di creare una nuova chat ma l'ultima creata non ha del contenuto non lo permette
         * 
         * @param chatIDPassato - se bisogna creare un metodo con un id specifico
         * @param daEliminare - variabile che serve a creare comunque una chat quando l'unica chat esistente viene eliminata anche se la chat è vuota, se no createNewChat sarebbe false
         * @author Ethan
         * @author Ahmed
         */
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

                if (!chatIDPassato) {

                    mostraPopupsystemPrompt(function (inputValue) {
                        systemPrompt = inputValue;

                        if (systemPrompt === "#cancel019283#") {
                            return;
                        }

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
                            '<span id="nomeChat">' + systemPrompt + '</span>' +
                            '<button class="chatButton" onclick="eliminaChat(event, \'' + chatID +
                            '\')"><i class="fas fa-trash-alt"></i></button></div>';
                        nuovaChatDiv.onclick = function () {
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
                        nuovaChatContainer.setAttribute('data-sys-prompt', systemPrompt);
                        nuovaChatContainer.classList.add('chat');


                        var systemPromptHeader = document.createElement('h2');
                        systemPromptHeader.textContent = "Prompt di sistema scelto: " + systemPrompt;
                        systemPromptHeader.style.paddingBottom = "20px";
                        nuovaChatContainer.appendChild(systemPromptHeader);

                        chatContainer.appendChild(nuovaChatContainer);



                        chatCounter++;
                        ultimaChatCreata = chatID;
                    });
                } else {

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
                            '<span id="nomeChat">' + "Nuova chat" + '</span>' +
                            '<button class="chatButton" onclick="eliminaChat(event, \'' + chatID +
                            '\')"><i class="fas fa-trash-alt"></i></button></div>';
                        nuovaChatDiv.onclick = function () {
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

            }
        }


        /**
         * Mostra un popup per chiedere all'utente come deve essere il systemPrompt.
         * @param callback - Funzione da chiamare con il valore del systemPrompt inserito dall'utente.
         * @author Ahmed
         * @autor Ethan
         */
        function mostraPopupsystemPrompt(callback) {

            var background = $('<div class="popup-background"></div>').css({
                position: 'fixed',
                top: 0,
                left: 0,
                width: '100%',
                height: '100%',
                backgroundColor: 'rgba(0, 0, 0, 0.7)',
                zIndex: '999'
            });

            // Creazione del popup
            var popup = $('<div></div>').css({
                position: 'fixed',
                top: '50%',
                left: '50%',
                transform: 'translate(-50%, -50%)',
                backgroundColor: '#fff',
                padding: '20px',
                paddingBottom: '25px',
                borderRadius: '5px',
                boxShadow: '0px 0px 10px rgba(0, 0, 0, 0.1)',
                zIndex: '1000'
            });

            var inputLabel = $('<h2>Inserisci il prompt di sistema:</h2>').css({
                color: '#000'
            });
            popup.append(inputLabel);

            var inputField = $('<input type="text">').css({
                width: '100%',
                marginTop: '10px',
                marginBottom: '20px'
            }).attr('placeholder', 'Inserisci prompt');
            popup.append(inputField);

            var buttonContainer = $('<div></div>').css({
                display: 'flex',
                justifyContent: 'space-between',
                marginTop: '10px'
            });

            var submitButton = $('<button>Conferma</button>').css({
                marginRight: '10px'
            }).click(function () {
                var inputValue = inputField.val();
                background.remove();
                popup.remove();
                callback(inputValue);
                if (!checkUserRegistration()) {
                    cambiaChat('chat_1');
                }
                cambiaChat(ultimaChatCreata);
            }).attr({
                id: 'conferma-btn',
                class: 'confirm-btn'
            });
            buttonContainer.append(submitButton);

            var cancelButton = $('<button>Annulla</button>').click(function () {
                var inputValue = "#cancel019283#";
                if ($('#elenco-chat').is(':empty')) {
                    alert('Inserire un prompt per la prima chat');
                } else {
                    background.remove();
                    popup.remove();
                    callback(inputValue);
                    if (!checkUserRegistration()) {
                        cambiaChat('chat_1');
                    }
                    cambiaChat(ultimaChatCreata);
                }
            }).attr({
                id: 'annulla-btn',
                class: 'cancel-btn'
            });

            buttonContainer.append(cancelButton);

            popup.append(buttonContainer);

            $('body').append(background);
            $('body').append(popup);
        }





        /**
         * Questo metodo serve a impostare il nome della chat in base al chatCounter
         * 
         * @param chatCounter - numero della chat
         * 
         * @return - ritorna il nome della chat
         * 
         * @autor Ethan
         */
        function impostaNomeChat(chatCounter) {
            //Funzione in disuso
            return null;
        }



        /**
         * Questo metodo viene chiamato solo al click sul pulsante "crea nuova chat" e serve a selezionare la chat che viene creata
         * 
         * @author Ethan
         */
        function cambiaChatAllaCreazione() {
            var chatID = 'chat_' + (chatCounter - 1);
            cambiaChat(chatID);
        }


        /**
         * Questo metodo serve a tenere la chat selezionata quando ne elimini un altra o a selezionaare la prima chat se elimini la chat in cui sei in quel momento
         * 
         * @param chatID - id della chat che si vuole eliminare
         * 
         * @author Ethan
         */
        function chatPiuGrande(chatID) {
            var chatContainer = document.getElementById('chat-container');
            var divs = chatContainer.getElementsByTagName('div');
            var maxId = 0;
            var maxIdNumber = 0;

            var activeChatId = $('.active-chat').attr('id');

            if (activeChatId != chatID && activeChatId != null) {
                return activeChatId.replace(/-container/g, '');
            }

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


        /**
         * Questo metodo fa comparire un popup per chiedere conferma se si vuole eliminare una chat e se si conferma la elimina sia a vista che dal db
         * 
         * @param event - evento che viene stoppato per evitare che venga selezionata la chat in cui si clicca il tasto del cestino
         * 
         * @param chatID - id della chat che si vuole eliminare
         * 
         * @exception errore se la chiamata ajax non va a buon fine
         * 
         * @author Ethan
         */
        function eliminaChat(event, chatID) {
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

                    success: function (data) {
                        // Rimuove la chat dallo schermo
                        var chatDiv = document.getElementById(chatID);
                        if (chatDiv) {
                            chatDiv.remove();
                        }

                        // Rimuove il contenitore dei messaggi della chat
                        var chatContainer = document.getElementById(chatID + '-container');
                        if (chatContainer) {
                            chatContainer.remove();
                        }
                        document.getElementById('overlay').style.display = 'none';

                        confermaBtn.removeEventListener('click', confermaClick);

                        cambiaChat(chatPiuGrande(chatID + '-container'));

                    },
                    error: function (error) { }
                });
            });

            annullaBtn.addEventListener('click', function annullaClick() {
                // Nasconde il popup senza eliminare la chat
                document.getElementById('overlay').style.display = 'none';

                annullaBtn.removeEventListener('click', annullaClick);
            });
        }




        /**
         * Questo metodo serve a cambiare la chat in base al chatID passato
         * 
         * @param chatID - id della chat selezionata
         * 
         * @author Ethan
         */
        function cambiaChat(chatID) {
            var element = document.getElementById(chatID);
            if (element) {

                var activeChatId = $(".active-chat").attr("id");
                if (activeChatId) {
                    $("#" + activeChatId.replace("-container", "")).css("background-color", "");
                }

                // Nascondi tutti i contenitori delle chat
                var chatContainers = document.querySelectorAll('.chat');
                chatContainers.forEach(function (container) {
                    container.classList.remove('active-chat');
                });

                // Mostra solo il contenitore della chat selezionata
                var chatContainer = document.getElementById(chatID + '-container');
                chatContainer.classList.add('active-chat');
                $('#' + chatID).css('background-color', '#004f00');

                // Inserisce i messaggi della nuova chat attiva
                var inputMessaggio = document.getElementById('messaggio-input');
                inputMessaggio.value = messaggiPerChat[chatID] || '';
            }

            $('#barra-destra').animate({
                scrollTop: $('#barra-destra').prop("scrollHeight")
            }, 'fast');





        }




        var canWrite = true;
        var chatModificate = [];
        var messaggiPerChat = {};
        var timestamps = [];

        /**
         * Questo metodo serve a inviare il messaggio e a far rispondere l'ia, se il messaggio ha più di 2000 caratteri non lo invia 
         * 
         * @exception errore se il messaggio è troppo lungo
         * 
         * @author Ethan
         */
        function inviaMessaggio() {

            var inputMessaggio = document.getElementById('messaggio-input');

            var messaggio = inputMessaggio.value;

            if (!messaggio || !canWrite) {
                return;
            }

            if (messaggio.length < 2000) {
                messaggiPerChat = {};

                messaggio = String(messaggio).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(
                    /"/g,
                    '&quot;');


                if (messaggio.trim() !== '') {
                    var chatContainer = document.querySelector('.active-chat');

                    // Aggiunge il messaggio alla chat
                    chatContainer.innerHTML += '<p>Tu:<br>' + messaggio + '</p>';

                    inputMessaggio.value = '';
                    inputMessaggio.style.height = 'auto';

                }
                // Salva chat modificata per update
                if (!chatModificate.includes(chatContainer.id)) {
                    chatModificate.push(chatContainer.id)
                }

                rispostaIa(messaggio);
            } else {
                alert("Messaggio troppo lungo, massimo 2000 caratteri");
            }

            $('#barra-destra').animate({
                scrollTop: $('#barra-destra').prop("scrollHeight")
            }, 'slow');

            autoResize();

            putOnTop(chatContainer.id.replace('-container', ''), false)

        }



        var canWrite = true;
        /**
         * Questo metodo serve a far rispondere l'ia in base al messaggio che gli viene passatos utilizzando una chiamata ajax verso un file python
         * 
         * @param domanda - messaggio che l'utente ha scritto
         * 
         * @author Ethan
         */
        function rispostaIa(domanda) {
            canWrite = false;
            var promptDiSistema = $(".active-chat h2:contains('Prompt di sistema scelto')").text().replace('Prompt di sistema scelto: ', '');
            var data = {
                domanda: domanda,
                promptDiSistema: promptDiSistema
            };

            var xhr = new XMLHttpRequest();

            // definizione la callback da eseguire quando riceviamo una risposta dal server
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {

                    var response = JSON.parse(xhr.responseText);

                    var chatContainer = document.querySelector('.active-chat');
                    chatContainer.innerHTML += '<p>Bot:<br>' + response.output + '</p>';

                    $('#barra-destra').animate({
                        scrollTop: $('#barra-destra').prop("scrollHeight")
                    }, 'fast');
                    canWrite = true;

                }
            };


            xhr.open('POST', 'http://127.0.0.1:5000/process_data', true);
            xhr.setRequestHeader('Content-Type', 'application/json');


            xhr.send(JSON.stringify(data));
        }





        /**
         * Questo metodo serve a salvare i dati in modo sincrono quando si chiude la pagina così da non dover fare query multiple
         * 
         * @author Ethan
         */
        window.onbeforeunload = function () {

            var isUserRegistered = checkUserRegistration();

            if (isUserRegistered) {

                salvaDatiSincronamente();

                updateChat();
            }


            return null

        };


        /**
         * Questo metodo salva i dati in modo sincrono nel database se l'utente è registrato
         * 
         * @author Ethan
         */
        function salvaDatiSincronamente() {
            var chatContainers = document.querySelectorAll('[id^="chat_"][id$="-container"]');

            // cicla i contenitori delle chat e salva il loro contenuto nel database
            chatContainers.forEach(function (container) {
                var chatID = container.id.replace('-container', '');
                var messages = container.innerHTML;
                var systemPrompt = container.getAttribute('data-sys-prompt');
                var nomeChat = document.querySelector("#" + chatID + " div span").textContent;
                var idExist = false;

                // controllo per evitare duplicati di chat nel db
                var messaggi = <?php echo json_encode($messaggi); ?>;
                var chatIDs = [];
                messaggi.forEach(function (messaggio) {
                    if (!chatIDs.includes(messaggio.ChatID)) {
                        chatIDs.push(messaggio.ChatID);
                    }
                });
                chatIDs.forEach(function (chatIDdb) {
                    if (chatIDdb == chatID) {
                        idExist = true;
                    }
                });

                if (idExist) {
                    return;
                }

                var idUtente = <?php echo json_encode(Auth::check() ? Auth::user()->id : null); ?>;

                if (messages) {

                    salvaChatNelDatabase(chatID, messages, idUtente, nomeChat, systemPrompt) // Passa systemPrompt
                        .then(function () { })
                        .catch(function (error) {
                            if (error.response) { }
                        });
                }
            });
        }





        /**
         * Questo metodo serve a salvare i messaggi nel database trammite una chiamata ajax
         * 
         * @param chatID - id della chat
         * 
         * @param messages - messaggi della chat
         * 
         * @param idUtente - id dell'utente
         * 
         * @param nomeChat - nome della chat
         * 
         * @exception errore se la chiamata ajax non va a buon fine
         * 
         * @return - ritorna la chiamata ajax
         * 
         * @author Ethan
         */
        function salvaChatNelDatabase(chatID, messages, idUtente, nomeChat, systemPrompt) {

            return axios.post('/messages', {
                chatID: chatID,
                message: messages,
                userCreationId: idUtente,
                nomeChat: nomeChat,
                systemPrompt: systemPrompt
            });
        }



        /**
         * Questo metodo serve a controllare se l'utente è registrato
         * 
         * @return - ritorna true se l'utente è registrato, false se non lo è
         * 
         * @author Ethan
         */
        function checkUserRegistration() {
            @if(Auth::check())
                return true
            @else
                return false
            @endif
        }



        /**
         * Qesto metodo serve ad aggiornare tutti i messaggi nel db di tutte le chat che sono state modificate
         * 
         * @exception errore se la chiamata ajax non va a buon fine
         * 
         * @author Ethan
         */
        function updateChat() {
            for (var i = 0; i < chatModificate.length; i++) {
                var chatContainer = document.getElementById(chatModificate[i]);
                var newMessage = chatContainer.innerHTML;
                var chatId = chatContainer.id.replace('-container', '');
                var formattedDateTime = new Date().toISOString().slice(0, 19).replace('T', ' ');

                $.ajax({
                    type: 'POST',
                    url: '/updateMessages',
                    data: {
                        newMessage: newMessage,
                        chatId: chatId,

                        _token: '{{ csrf_token() }}'
                    },
                    success: function (data) { },
                    error: function (error) { }
                });

            }
        }



        /**
         * Questo metodo serve a chiudere la barra sinistra quando si clicca sulla freccia
         * 
         * @author Ethan
         */
        function chiudiBarraSinistra() {
            var barraSinistra = document.getElementById('barra-sinistra');
            var freccia = document.getElementById('freccia');
            var barraInvio = document.getElementById('barra-invio');
            barraSinistra.classList.toggle('chiusa');
            freccia.classList.toggle('chiusa');
            barraInvio.classList.toggle('chiusa');


            requestAnimationFrame(aggiornaLarghezzaBarraInvio);
        }


        /**
         * Metodo per aggiornare dinamicamente la larghezza di #barra-invio per adattarsi alla larghezza corrente del contenitore #chat-container.
         * 
         * @autor Ethan
         */
        function aggiornaLarghezzaBarraInvio() {
            $("#barra-invio").css("width", $("#chat-container").width() + 43);
            requestAnimationFrame(aggiornaLarghezzaBarraInvio);
        }


        /**
         * Questo metodo serve a controllare le dimensioni della finestra e a chiudere la barra sinistra se la finestra è troppo piccola
         * 
         * @author Ethan
         */
        function controllaDimensioniFinestra() {
            var larghezzaFinestra = window.innerWidth;
            var barraSinistra = document.getElementById('barra-sinistra');
            var freccia = document.getElementById('freccia');
            var barraInvio = document.getElementById('barra-invio');

            if (larghezzaFinestra < 800) {
                barraSinistra.classList.add('chiusa');
                freccia.classList.add('chiusa');
                barraInvio.classList.add('chiusa');
            } else {
                barraSinistra.classList.remove('chiusa');
                freccia.classList.remove('chiusa');
                barraInvio.classList.remove('chiusa');
            }

            $("#barra-invio").css("width", $("#chat-container").width() + 43);

        }

        // ascoltatore di eventi per il resize della finestra
        window.addEventListener('resize', controllaDimensioniFinestra);







        /**
         * Qesto metodo serve a fare comparire il box delle opzioni se si clicca sul pulsante opzioni
         * 
         * @author Ethan
         */
        document.addEventListener('click', function (event) {
            var optionsDiv = document.getElementById("opzioni");
            var targetElement = event.target;

            // Controlla se si ha cliccato all'interno di opzioni
            var isClickInsideOptions = optionsDiv.contains(targetElement);

            // Se si clicca fuori da opzioni, chiudere il menu
            if (!isClickInsideOptions && optionsDiv.classList.contains("active")) {
                optionsDiv.classList.remove("active");
            }
        });



        /**
         * Queto metodo serve a far comparire/togliere il box delle opzioni
         * 
         * @author Ethan
         */
        function toggleOptions(event) {
            event
                .stopPropagation();
            var optionsDiv = document.getElementById("opzioni");
            optionsDiv.classList.toggle("active");
        }


        /**
         * Questo metodo serve a far comparire il popup per chiedere conferma se si vuole eliminare tutte le chat
         * 
         * @author Ethan
         */
        function mostraPopupSvuotaChat() {
            document.getElementById('overlay2').style.display = 'flex';

        }


        /**
         * Questo metodo serve a chiudere il popup che chiede se si vuole eliminare tutte le chat
         * 
         * @author Ethan
         */
        function chiudiPopup2() {
            document.getElementById('overlay2').style.display = 'none';
        }


        /**
         * Questo metodo serve a far apparire un popup per chiedere conferma se si vuole eliminare tutte le chat e fa comparire una chat vuota
         * 
         * @exception errore se la chiamata ajax non va a buon fine
         * 
         * @author Ethan
         */
        function svuotaChat() {

            var elencoChat = document.getElementById("elenco-chat");

            var chatDaEliminare = [];

            if (elencoChat) {
                // seleziona tutti gli elementi figli che hanno un ID che inizia con "chat_"
                var figli = elencoChat.querySelectorAll("[id^='chat_']");

                // cicla le chat e ne salva gli ID
                figli.forEach(function (figlio) {
                    chatDaEliminare.push(figlio.id);
                });
            }

            for (var i = 0; i < chatDaEliminare.length; i++) {
                (function (i) {
                    $.ajax({
                        type: 'POST',
                        url: '/deleteChat',
                        data: {
                            chatId: chatDaEliminare[i],
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (data) {
                            // Rimuove la chat dallo schermo
                            var chatDiv = document.getElementById(chatDaEliminare[i]);
                            if (chatDiv) {
                                chatDiv.remove();
                            }

                            // rimuove il contenitore dei messaggi della chat
                            var chatContainer = document.getElementById(chatDaEliminare[i] + '-container');
                            if (chatContainer) {
                                chatContainer.remove();
                            }

                        },
                        error: function (error) { }
                    });
                })(i);
            }

            document.getElementById('overlay2').style.display = 'none';
            creaNuovaChat("", "EliminaUnicaChat");
            cambiaChat(ultimaChatCreata);
        }


        /**
         * Questo metodo serve a spostare in cima la chat in qui si ha scritto o a ordinare le chat in base all'ultima data di modifica
         * 
         * @param idChat - id della chat da spostare in cima se non è da db
         * 
         * @param fromDb - se si vuole fare un ordinamento delle chat del db in base all'ultima modifica
         * 
         * @author Ethan
         */
        function putOnTop(idChat, fromDb) {
            if (!fromDb) {
                var chatDaSpostare = $('#' + idChat);

                chatDaSpostare.detach();

                $('#elenco-chat').prepend(chatDaSpostare);
            } else {
                var messaggi = <?php echo json_encode($messaggi); ?>;


                /**
                 * Il metodo ordina le date di messaggi in base alla data di aggiornamento, confrontando le date di aggiornamento.
                 *
                 * @param a Primo elemento da confrontare.
                 * 
                 * @param b Secondo elemento da confrontare.
                 * 
                 * @return Un valore negativo se a.updated_at è successivo a b.updated_at, zero se sono uguali o altrimenti un valore positivo.
                 * 
                 * @author Ethan
                 */
                messaggi.sort(function (a, b) {
                    return new Date(b.updated_at) - new Date(a.updated_at);
                });


                for (var i = messaggi.length - 1; i >= 0; i--) {
                    var chatDaSpostare = $('#' + messaggi[i].ChatID);
                    $('#elenco-chat').prepend(chatDaSpostare);
                }


                cambiaChat(messaggi[0].ChatID);

            }

        }
    </script>
</body>

</html>