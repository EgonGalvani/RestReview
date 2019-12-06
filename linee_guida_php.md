# LINEE GUIDA PHP 

## CARATTERISTICHE COMUNI
In tutte le pagine devono essere introdotti gli elementi di: 
- Menu ( %MENU% )
- Header ( %HEADER% )
<br />
TUTTI I PLACEHOLDER SONO NELLA FORMA: %PLACEHOLDER%

## LOGIN 
### CONTENUTO FORM 
Nel form della pagina login sono presenti i seguenti campi di input: 
- email [name: email]
- password [name: password]
- una checkbox "Ricordati di me" [name: remember_me] (da implementare tramite cookie)
- il bottone di submit [name: accedi]
### VINCOLI 
- password ed email devono essere non vuoti e rispettare le regex riportate alla fine della pagina 

## REGISTRAZIONE 
### CONTENUTO FORM 
Nel form di registrazione sono presenti i seguenti campi: 
- radio button per la tipologia dell'utente [name: tipo_utente] [value: rec | rist]
- email [name: email]
- nome [name: nome]
- cognome [name: cognome]
- sesso [name: sesso] [value: ns | uomo | donna | altro ]
- data di nascita [name: nascita]
- password [name: password]
- ripetizione password [name: repeatpassword]
- partiva iva [name: piva]
- ragione sociale [name: rsoc]
- immagine di profilo [name: img_profilo] [valore contenuto in $_FILE]
- bottone di submit [name: registrati]
### VINCOLI 
- password ed email devono essere non vuoti e rispettare le regex riportate alla fine della pagina
- nome e cognome devono avere lunghezza minima di 2 caratteri e non possono presentare numeri al proprio interno 
- password e la relativa ripetizione devono essere uguali 
- la data di nascita deve imporre che l'utente abbia almeno 12 anni 
- partita iva e ragione sociale sono campi necessari solo per i ristoratori
- eventuali controlli sulla lunghezza della partita iva 
- tutti i campi sono obbligatori 

## INSERIMENTO RISTORANTE 
### CONTENUTO FORM 
Nel form di inserimento dei ristoranti sono presenti i seguenti campi: 
- nome del ristorante [name: nome]
- breve descrizione [name: b_descrizione]
- tipologia del ristorante [name: tipologia] [E' presente il placeholder %TIPOLOGIA% che deve essere rimpiazzato dalla lista delle possibili option]
- numero di telefono [name: telefono]
- email [name: email]
- sito [name: sito] 
- orario di apertura [name: o_apertura]
- orario di chiusura [name: o_chiusura]
- radio button per il giorno di chiusura [name: free_day] [value: lun | mar | mer | gio | ven | sab | dom]
- via del ristorante [name: via]
- civico [name: civico]
- città [name: citta]
- cap [name: cap]
- immagine prinicipale del ristorante (quella mostrata nei risultati di ricerca) [name: main_photo]
- immagini aggiuntive di presentazione del ristorante [name: minor_photo] 
### VINCOLI 
- il nome del ristorante deve avere lunghezza minima di 6 caratteri 
- la descrizione deve avere lunghezza minima di 25 caratteri
- NON sono obbligatori: sito, numero di telefono, email, immagini aggiuntive 
- possono essere caricate al massimo 3 immagini aggiuntive 

## REGEX UTILIZZATE: 
- emailRegex = /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/;
- pswRegex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/; 

## MESSAGGI DI SUCCESSO/WARNING/ERRORE 
Se fosse necessario mostrare eventuali messaggi all'utente (es. dopo registrazione o inserimento ristorante) si può usare un div con la classe msg_box e una classe tra: error_box, success_box e warning_box. Indicando all'interno del div il messaggio da mostrare all'utente. 
