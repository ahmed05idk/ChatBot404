<!-- resources/views/homeStyle.blade.php -->

<!DOCTYPE html>
<html lang="en">

<head>
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
        width: 15rem;
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
        justify-content: flex-end;
        align-items: center;
        margin-bottom: 20px;
        height: 30px;
        gap: 10px;
    }

    .login-register {
        display: flex;
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
        /*z-index: 1000;*/
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

    .nav-link {
        display: flex;
    }

    .chatButton {
        background-color: #2e8500;
        color: #e60000;
        margin-left: 24%;
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
    left: 15rem;
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
    overflow: hidden;
    transition: width 0.5s ease;
}

#barra-sinistra.chiudi {
    width: 0;
    padding: 0;
    margin: 0;
}

#opzioni {
    display: none;
    background-color: white;
    border: 1px solid black;
    margin-left: 20px; /* Spostato leggermente a sinistra */
    margin-top: 30px; /* Spostato leggermente più in basso */
    position: absolute;
    right: 2%;
}

.opzioni-visible {
    display: block;
}

.opzione {
border: 1px solid black;
padding: 5px 10px;
}
.opzione:hover {
background-color:#2e8500;
}




    </style>
</head>

</html>