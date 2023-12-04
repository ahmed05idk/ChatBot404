# Non modificate roba pls che se no è un casino

aggiungere cartella php alle variabili di sistema

installare composer


aprire xampp

schiacciare su admin di mysqul alla porta 3306

creare database chatBotData


andare nella cartella test1 creare una copia di .env.example e rinominarlo in.env all interno cambiare DB_DATABASE=chatBotData


andare nella cartella da cmd
cd "C:\Users\eindemini\OneDrive - edu.ti.ch\Desktop\Scuola\Terzo anno\Progetto\ChatBot404\test1"

nel cmd fare
php artisan serve


una volta avviato andate alla pagina http://127.0.0.1:8000/

schiacciare su generate app key nel riquadro a destra e ricaricare 





crea file login nella cartella auth
php artisan make:view auth.login






warning: in the working copy of 'php-8.3.0/snapshot.txt', LF will be replaced by CRLF the next time Git touches it












todo

non trasporta messaggio chat tra una pagina e l'altra
quando sei loggato devi vedere tasto profilo e non più login e register
mettere logout
quando scrivi messaggio va a capo a fine box input 
messaggi scritti vanno a capo a fine pagina
bug che non puoi scrivere nella pagina iniziale
non ti salva la pagina iniziale se ne crei una nuova
non va enter per scrivere
deve salvare la chat nel db così che se sei loggato e ricarichi la pagina ti ri mette le tue chat
