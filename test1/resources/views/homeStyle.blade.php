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

    #containerPrincipale,
    #rigaPrincipale,
    #barra-destra,
    #contenitore-input {
        background:
            linear-gradient(27deg, #151515 5px, transparent 5px) 0 5px,
            linear-gradient(207deg, #151515 5px, transparent 5px) 10px 0px,
            linear-gradient(27deg, #222 5px, transparent 5px) 0px 10px,
            linear-gradient(207deg, #222 5px, transparent 5px) 10px 5px,
            linear-gradient(90deg, #1b1b1b 10px, transparent 10px),
            linear-gradient(#1d1d1d 25%, #1a1a1a 25%, #1a1a1a 50%, transparent 50%, transparent 75%, #242424 75%, #242424) !important;
        background-color: #131313 !important;
        background-size: 20px 20px !important;
    }

    html,
    body {
        height: 100%;
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        color: white;

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

        position: fixed;
        bottom: 0;

        box-sizing: border-box;
        align-items: flex-end;

        justify-content: left;
        background-color: rgba(255, 255, 255, 0);
        

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
        z-index: 1000;
    }

    .popup {
        background: #fff;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        position: relative;
        z-index: 1000;
        color: black;
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
        color: gray;
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
        padding: 0 20px 20px 20px;
        overflow-y: auto;
        transition: transform 0.5s ease, width 0.5s ease;
        text-align: center;
    }

    #barra-sinistra.chiusa {
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
        margin-top: 40px;
        margin-bottom: 40px;
        transition: margin-bottom 0.3s ease;
    }

    #messaggio-input {
        width: 100%;
        padding: 10px;
        box-sizing: border-box;
        border: 1px solid #ccc;
        border-radius: 5px;
        resize: none;/*
        height: 88%;
        max-height: 200px;*/
        overflow-y: auto;
    }

    #invia-bottone {
        background-color: #4CAF50;
        color: white;
        border: none;
        cursor: pointer;
        margin-left: 0;
        border-radius: 5px;
        height: 70px;
    }

    .chatButton {
        background-color: #2e8500;
        color: #e60000;
        border: 10px;
    }


    #boxTitleCreateChat {
        padding-top: 20px;
        position: sticky;
        top: 0;
        background-color: #333;
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
        color: black;
    }

    .opzione:hover {
        background-color: #2e8500;
    }


    p {
        margin-bottom: 40px;
    }
    </style>
</head>

</html>