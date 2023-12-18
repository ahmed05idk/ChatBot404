# Non modificate roba pls che se no è un casino

aggiungere cartella php alle variabili di sistema

installare composer


aprire xampp

schiacciare su admin di mysqul alla porta 3306

creare database chatBotData

// forse fixato e non serve
andare nella cartella test1 creare una copia di .env.example e rinominarlo in.env all interno cambiare DB_DATABASE=chatBotData


andare nella cartella da cmd
cd "C:\Users\eindemini\OneDrive - edu.ti.ch\Desktop\Scuola\Terzo anno\Progetto\ChatBot404\test1"

nel cmd fare
php artisan serve


una volta avviato andate alla pagina http://127.0.0.1:8000/

schiacciare su generate app key nel riquadro a destra e ricaricare 





crea file login nella cartella auth
php artisan make:view auth.login



creare tabella per nuovo database senza ancora inserirla nel db
php artisan make:migration messages


crea la tabella della migration nel db
php artisan migrate


Per agginta campi a tabella:

crei migrazione
php artisan make:migration add_nomeCampo_to_nomeTabella_table

andare nel file appena creato database\migration\nomefile

sostituire la funzione up con

    public function up()
    {
        Schema::table('messages', function (Blueprint $table) { // al posto di message mettere nome tabella
            $table->text('ChatID'); // Cambia il tipo di dato in base alle tue esigenze o il nome campo
        });
    }
    
e poi fare 
php artisan migrate

todo

deve salvare la chat nel db così che se sei loggato e ricarichi la pagina ti ri mette le tue chat
eliminare le chat
pass o email errati nel login se sbagliati
password dimenticata
verifica dell email
