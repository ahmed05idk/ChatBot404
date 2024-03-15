<!-- resources/views/layouts/app.blade.php -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    

    <style>
    form {
        text-align: center;
    }

    body {
        background-color: #f8f9fa;
    }

    .container {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 96vh;
        padding: 20px;
    }
    .container-fluid {
        padding: 20px !important;
    }

    .card {
        width: 400px;
        border: 1px solid #ced4da;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }


    .form-group {
        margin-bottom: 20px;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        width: 100%;
        height: 40px;
        color: white;
        font-size: 20px;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }

    .btn-link {
        color: #007bff;
    }

    .btn-link:hover {
        text-decoration: underline;
    }

    .form-control {
        width: 70%;
        height: 40px;
        margin-bottom: 20px;
    }

    .form-control::placeholder {
        font-size: 20px;
    }

    .back-button {
        display: inline-block;
        text-decoration: none;
        color: #000;
        font-size: 30px;
        width: 40px;
    }
    #wrongPassMail{
        color: red;
    }
    
#verificationBox {

    justify-content: center;

}
.emailAndVer{
    padding: 0 !important;
}
.row{
    margin:0 !important;
}   

#changeLogReg{
        padding: 2px 0 5px 0;
        border-top: 1px solid black;
       
}



    </style>
</head>

<body>
    <div id="app">
        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <!-- Aggiungi qui i tuoi script JS, librerie, ecc. -->
</body>

</html>