

Lista file importanti/che ho usato:

    test1\routes\web -> salvataggio nel db di chat e account utenti, per utenti utilizza i controller per salvare e validare


    test1\app\Http\Controllers\Auth -> file per logn/register

    test1\app\Http\Controllers\Auth\VerificationController -> creazione numero casuale da usare nella verifica mail

    test1\app\Http\Controllers\Auth\AuthController -> funzioni di validazione/salvataggio nel db delle credenziali dell account

    test1\app\Http\Controllers\Auth\AuthControllerfunzioni di validazione/salvataggio nel db delle chat


    test1\resources\views\home -> parte html della home del sito

    test1\resources\views\homeJs -> parte js della home del sito

    test1\resources\views\homeStyle -> parte css della home del sito

    test1\resources\views\verificationeEmail -> template della mail che viene inviata quando ti registri


    test1\app\Models\Message -> campi richiesti per il salvataggio nel db della chat

    test1\app\Models\user -> campi richiesti per il salvataggio nel db del utente


    test1\database\migrations -> quando devo fare update o aggiungere campi del db creo una migration qua


    test1\.env -> variabili che utiliza il progetto come ad esempio la connessione al db o la mail per mandare l'email d verifica






_token: '{{ csrf_token() }}' // Aggiungi questa linea per includere il token CSRF da errore se non lo metti in una chiamata Ajax




mail: help.chatbot404@gmail.com
pass: ChatBot404