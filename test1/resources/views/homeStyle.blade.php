<!-- resources/views/homeStyle.blade.php -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <style>
    #containerPrincipale,
    #rigaPrincipale,
    #barra-destra {
        height: 100%;
        padding: 0;
        max-width: 100%;
        margin: 0;
    }

    html,
    body {
        height: 100%;
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;

    }


    #barra-destra {
        flex: 3;
        display: flex;
        flex-direction: column;
        padding: 0px 20px 0px 20px;
        overflow-y: auto;
        height: 100vh;
        position: relative;
    }


    #barra-sopra {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        margin: 10px 0 20px 0;
        height: 30px;
        gap: 10px;
    }

    #elenco-chat {
        margin-bottom: 20px;
    }


    #barra-invio {
        display: flex;
        position: sticky;
        bottom: 0;
        width: 100%;
        background-color: #fff;
        padding: 20px;
        box-sizing: border-box;
        align-items: flex-end;
        min-height: 9%;
    }

    #barra-sotto {
        width: 99%;
        position: absolute;
        bottom: 0;
    }


    .overlayPopup {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        align-items: center;
        justify-content: center;
    }

    .popup {
        background: #fff;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        position: relative;
        z-index: 1000;
    }

    .close-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        cursor: pointer;
    }

    .btn-container {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
    }

    .confirm-btn,
    .cancel-btn {
        padding: 10px;
        cursor: pointer;
        border: none;
        border-radius: 5px;
        color: #fff;
    }

    .confirm-btn {
        background-color: #4caf50;
    }

    .cancel-btn {
        background-color: #f44336;
    }

    #freccia {
        position: fixed;
        top: 50%;
        left: 18rem;
        transform: translateY(-50%);
        width: 40px;
        height: 50px;
        border: none;
        z-index: 1;
        transition: left 0.5s ease;
        background: none;
    }

    #freccia.chiusa {
        left: 0;
        transform: translate(-0%, -50%) rotateY(180deg);
    }

    #barra-sinistra {
        width: 300px;
        height: 100vh;
        background-color: #333;
        color: #fff;
        padding: 20px;
        overflow-y: auto;
        transition: transform 0.5s ease;
        text-align: center;
    }

    #barra-sinistra {
        width: 300px;
        height: 100vh;
        background-color: #333;
        color: #fff;
        padding: 20px;
        overflow-y: auto;
        transition: transform 0.5s ease, width 0.5s ease;
        /* Aggiungi una transizione alla larghezza */
    }

    #barra-sinistra.chiudi {
        transform: translateX(-300px);
        width: 0;
        padding: 0;
    }


    .chat-item {
        cursor: pointer;
        padding: 10px;
        margin-bottom: 5px;
        background-color: #2e8500;
        border-radius: 5px;
        margin: 0.5rem;
    }

    .chat:not(.active-chat) {
        display: none;
    }

    #chat-container {
        flex: 1;
        word-wrap: break-word;
        padding-top: 40px;
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

    .chatButton {
        background-color: #2e8500;
        color: #e60000;
        border: 10px;
    }

    /* Stile generale per tutte le barre di scorrimento */

    ::-webkit-scrollbar {
        width: 10px;
    }

    ::-webkit-scrollbar-thumb {
        background-color: grey;
        border-radius: 8px;
    }

    ::-webkit-scrollbar-track {
        background-color: transparent;
    }


    html {
        scrollbar-width: thin;
        scrollbar-color: grey transparent;
    }


    html:hover {
        scrollbar-width: thin;
        scrollbar-color: transparent transparent;
        transition: scrollbar-color 0.5s ease;
    }



    #opzioni {
        display: none;
        background-color: white;
        border: 1px solid black;
        position: absolute;
        right: 2%;
    }

    #opzioni.active {
        display: block;
    }

    .opzione {
        border: 1px solid black;
        padding: 5px 10px;
    }

    .opzione:hover {
        background-color: #2e8500;
    }
    </style>
</head>

</html>