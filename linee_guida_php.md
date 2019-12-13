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
- radio button per la tipologia dell'utente [name: tipo_utente] [value: 0(recensore) | 1(ristoratore)]
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
- controlli sulle immagini (vedi sezione alla fine del documento)

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
- controlli sulle immagini (vedi sezione alla fine del documento)


## LE MIE RECENSIONI
### PLACEHOLDER 
- %LIST% : deve essere sostituito dalla list di recensione dell'utente, ordinate dalla più nuova alla più vecchia 
### PERMESSI 
Solo gli utenti loggati e di tipo RECENSORE possono accedere a tale pagina. Se l'utente considerato non rientra in tale categoria, allora forse è meglio rimandarlo a una pagina di errore o ad esempio alla home, in cui si potrebbe introdurre un box di errore (vedi relativa sezione). 

NOTA: Una lista di recensioni viene definnita nel seguente modo: 
``` 
<dl class="card_list rec_list">
    lista di item recensione
</dl>
```

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
- %NOME_RISTORANTE% : nome del ristorante a cui si riferisce la recensione
- %LIKE_FORM% : il funzionamento è spiegato nella sezione successiva
#### FUNZIONAMENTO 
- I form di eliminazione e di apertura del ristorante funzionano usando un campo hidden, contenente l'id della recensione/ristorante considerato. 
- La gestione del like risulta essere più complicata: (VALORE DI %LIKE_FORM%)
1. Se l'utente non ha ancora messo like, allora al post di %LIKE_FORM% deve essere inserito il form che è presente nei commenti del component
2. Se invece l'utente ha già messo like, gli viene mostrata una semplice immagine (presente anche questo come commento nel file component) 

### RECENSIONE ALTRUI 
#### PLACEHOLDER 
- %TITOLO% : titolo recensione 
- %DATA% : data recensione 
- %NOME_UTENTE% : nome del recensore 
- %COGNOME_UTENTE% : cognome del recenore 
- %URL_IMG_PROFILO% : url dell'immagine di profilo dell'utente 
- %CONTENUTO% : contenuto recensione 
- %NUMERO_STELLE% : numero di stelle della recensione(da 1 a 5)
- %LISTA_STELLE% : lista stelle (sottoforma di entità)
- %NUMERO_MI_PIACE% : numero di mi piace alla recensione 
- %LIKE_FORM% : funziona nello stesso modo della recensione dell'utente loggato (vedi paragrafo precedente)
- %DELETE_FORM% : 
    1. l'utente normale non vede nulla (--> il placeholder viene semplicemente rimipiazzato da una stringa vuota)
    2. se l'utente è amministratore deve comparire il form di eliminazione (presente nei commenti dell'item) 
    3. bisogna decidere se far vedere l'item recensione_utente_loggato o item_recensione quando navigando nelle recensioni di un ristorante, un utente trova una recensione scritta da lui stesso 

## ULTIMI RISTORANTI 
### PLACEHOLDER 
- %LIST% : deve essere rimpiazzato con la lista dei ristoranti 

NOTA: Una lista di ristoranti viene creata nel seguente modo: 
``` 
    <dl class="card_list rist_list">
        elenco di item ristorante            
    </dl>
``` 

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

## PAGINA INDEX
### PLACEHOLDER 
- %TIOLOGIA% : lista di option della select delle varie tipologie di ristoranti 
- %LIST: 
    1. Nel caso non sia ancora avvenuta una ricerca, allora la lista deve presentare i suggerimenti di ricerca. Al posto di %LIST% dovrà essere messo un titolo (h2) "Suggerimenti di ricerca: " seguito da una lista degli N ristoranti meglio recensiti del sito 
    2. Nel caso in cui sia avvenuta una ricerca, il titolo deve essere "Risultati di ricerca: ", seguito da una lista di ristoranti 
### FUNZIONAMENTO
I campi del form sono: 
- Stringa di ricerca (name: search)
- Tipologia di ricerca (per posizione o per nome) (name: filter) (value: 0 (per posizione), 1 (per nome))
- Tipologia del ristorante (name: tipologia)

### PLACEHOLDER
- %LIST% : deve essere rimpiazzato i suggerimenti di ricerca. Quindi con i primi N (es. N=5) ristoranti meglio recensiti. Deve essere usato come item l'item_ristorante

## REGEX UTILIZZATE: 
- emailRegex = usare quella di https://emailregex.com/
- pswRegex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/; 

## ENTITA' STELLE
- stelle piene: &amp;#9733;
- stelle vuote: &amp;#9734;

## MESSAGGI DI SUCCESSO/WARNING/ERRORE 
Se fosse necessario mostrare eventuali messaggi all'utente (es. dopo registrazione o inserimento ristorante) si può usare un p con la classe msg_box e una classe tra: error_box, success_box e warning_box. Indicando all'interno del div il messaggio da mostrare all'utente. Esempio: 
```
    <p class"msg_box error_box">
        MESSAGGIO DI ERRORE
    </p>
```

## CONTROLLI SULLE IMMAGINI 
Per ogni immagine bisogna controllare: 
 - Estensione (jpg | png | jpeg )
 - Dimensione Massima 5MB

## GESTIONE DEI RISULTATI IN PIU PAGINE 
Per disporre la lista di pagine in modo centrale, è necessario usare come padre un div con classe "center", 
se si vogliono bloccare i bottoni per passare alla pagina successiva/precedente (quelli alle estremità)
basta aggiungere la classe "disabled". L'item attuale deve essere uno span (non un link) e deve avere class="active". 
Esempio: 
```html
    <div class="center">
        <div class="pagination">
            <span class="disabled">&laquo;</span>
            <a href="" class="">1</a>
            <span class="active">2</span>
            <a href="#" class="">3</a>
            <a href="#" class="">4</a>
            <a href="#" class="">5</a>
            <a href="#" class="">6</a>
            <a href="#" class="">&raquo;</a>
        </div>
    </div>
```
