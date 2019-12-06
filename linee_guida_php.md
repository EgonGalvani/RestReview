# LINEE GUIDA PHP 

## CARATTERISTICHE COMUNI
In tutte le pagine devono essere introdotti gli elementi di: 
- Menu ( %MENU% )
- Header ( %HEADER% )
<br />
TUTTI I PLACEHOLDER SONO NELLA FORMA: %PLACEHOLDER%

## MENU 
Se l'utente è un amministratore, allora deve comparire nel menu la sezione: 
 - Pannello di amministrazione 
Se l'utente è un recensore, allora deve comparire anche: 
 - Le mie recensioni 
Se è un ristoratore, allora deve essere presente: 
 - I miei ristoranti 
Infine, se l'utente non è loggato, allora non va aggiunta alcuna sezione nel menu. 
NOTA: L'item del menu relativo alla pagina attuale non deve essere un link e deve presentare la classe 'active'. E' quindi una buona idea non usare il component, ma usare direttamente php per creare il menu.  

## BREADCRUMB 
Bisogna vedere se diventa necessario introdurre il breadcrumb in modo dinamico per pagine che possono essere raggiunte in più modi (es. dettaglio ristorante può essere raggiunto tramite risultati di ricerca, index, le mie recensioni, ecc. )

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


## LE MIE RECENSIONI
### PLACEHOLDER 
- %LIST% : deve essere sostituito dalla list di recensione dell'utente, ordinate dalla più nuova alla più vecchia 
### PERMESSI 
Solo gli utenti loggati e di tipo RECENSORE possono accedere a tale pagina. Se l'utente considerato non rientra in tale categoria, allora forse è meglio rimandarlo a una pagina di errore o ad esempio alla home, in cui si potrebbe introdurre un box di errore (vedi relativa sezione). 
### TODO
- Gestione dei risultati in più pagine (quando l'utente ha lasciato molte recensioni )

## ITEM RECENSIONE 

### RECENSIONE SCRITTA DALL'UTENTE LOGGATO 
#### PLACEHOLDER
- %TITOLO% : titolo della recensione 
- %DATA% : data della recensione 
- %CONTENUTO% : contenuto testuale della recensione 
- %NUMERO_STELLE%: numero (intero) di stelle attribuite dalla recensione al ristorante 
- %LISTA_STELLE%: se l'utente ha dato n stelle su 5, allora verranno mostrate n entità di stelle piene e 5-n entità di stelle vuote (vedere la fine del documento per l'entità da usare)
- %NUMERO_MI_PIACE% : numero di mi piace alla recensione 
- %ID_RECENSIONE% : id della recensione
- %ID_RISTORANTE% : id ristorante 
- %LIKE_FORM% : il funzionamento è spiegato nella sezione successiva
#### FUNZIONAMENTO 
- I form di eliminazione e di apertura del ristorante funzionano usando un campo hidden, contenente l'id della recensione/ristorante considerato. 
- La gestione del like risulta essere più complicata: (VALORE DI %LIKE_FORM%)
1. Se l'utente non ha ancora messo like, allora al post di %LIKE_FORM% deve essere inserito il form che è presente nei commenti del component
2. Se invece l'utente ha già messo like, gli viene mostrata una semplice immagine (presente anche questo come commento nel file component) 

### RECENSIONE ALTRUI 
ANCORA DA FARE IN HTML 

## ULTIMI RISTORANTI 
### PLACEHOLDER 
- %LIST% : deve essere rimpiazzato con la lista dei ristoranti 
### TODO 
- Gestione di più pagine di risultati 

## ITEM RISTORANTE 
### PLACEHOLDER
- %NOME% : nome ristorante 
- %PATH_IMG% : path dell'immagine principale del ristorpante 
- %INDIRIZZO% : indirizzo completo ristorante 
- %NUMERO_STELLE% : numero di stelle medie del ristorante 
- %LISTA_STELLE% : ipotizzando che il ristorante abbia una media di 4.3 stelle, allora devono essere mostrate k entità di stelle piene e 5-k entità di stelle vuote (dove k è il troncamento della media, nel nostro esempio di 4.3 stelle di media, allora k sarebbe 4)
- %DESCRIZIONE% : descrizione del ristorante 
- %ID_RISTORANTE% : id del ristorante 
- %FORM_ELIMINAZIONE% : vedi funzionamento 
### FUNZIONAMENTO 
- L'item presenta al suo interno un form, in cui è presente un campo hidden, che contiene al suo interno l'id del ristorante. Quando l'utente preme il bottone "Vai al ristorante", allora viene chiamata la pagina dettaglioristorante.html, con method GET. Si verrà reindirizzati quindi alla pagina: dettaglioristorante.html?id=VALORE_ID
- Il %FORM_ELIMINAZIONE% deve essere: 
    1. sostituito con una stringa vuota nel caso in cui l'utente loggato non sia il proprietario del ristorante 
    2. essere sostituito con il form di eliminazione (presente nei commenti del component). Tale form presenta al suo interno un placeholder %ID_RISTORANTE%, che in caso deve essere sostituito con l'id del ristorante


## PAGINA "HOME" (index.html)
### PLACEHOLDER
- %LIST% : deve essere rimpiazzato i suggerimenti di ricerca. Quindi con i primi N (es. N=5) ristoranti meglio recensiti. Deve essere usato come item l'item_ristorante

## REGEX UTILIZZATE: 
- emailRegex = usare quella di https://emailregex.com/
- pswRegex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/; 

## ENTITA' STELLE
- stelle piene: &amp;#9733;
- stelle vuote: &amp;#9734;

## MESSAGGI DI SUCCESSO/WARNING/ERRORE 
Se fosse necessario mostrare eventuali messaggi all'utente (es. dopo registrazione o inserimento ristorante) si può usare un div con la classe msg_box e una classe tra: error_box, success_box e warning_box. Indicando all'interno del div il messaggio da mostrare all'utente. 
