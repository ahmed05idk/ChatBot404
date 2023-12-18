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
        justify-content: flex-end;
        /* Cambiato da space-between a flex-end */
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

    .nav-link {
        display: flex;
    }
    </style>
</head>

</html>