## GENERALE 

### HTML 
In tutte le pagine si è tentato di usare unicamente xhtml 1.1, in modo da aver una compatibilità più elevata con i vari browser. 
Nei form si è deciso di usare unicamente i campi di input messi a disposizione da xhtml 1.1: eventuali controlli sul formato e contenuto di tali campi è stato eseguito in javascript. 
In alcune pagine (es. faq) si è deciso di usare html5, per supportare un maggior livello di accessibilità. In ogni caso, anche tali pagine, dovrebbero essere visibili senza alcuna tipologia di problema anche su browser che non supportano html5.  

### CSS 
La maggior parte del css è css2. Nel caso di utilizzo di alcune regole introdotte da css3, esse sono state disposte alla fine del blocco di regole. Questo permette a browser che non supportano css3 di eseguire in modo adeguato almeno tutte le regole css2. 

### JS
Javascript è stato usato in un numero limitato di pagine, con i seguenti scopi:  
- Controlli sui form 
- Preview di immagini 
- Garantire maggiore accessibilità  
In ogni caso, tutte le pagine influenzate da codice javscript possono essere visualizzate in modo corretto anche se quest'ultimo risulti essere disabilitato. In questo caso abbiamo ritenuto adeguato mostrare all'utente un messaggio di warning relativo al possibile non disponibilità di alcune funzionalità. 


## BASE 
La pagina base.html rappresenta la scheletro delle altre pagine. Viene utilizzata una struttura a tre pannelli per rendere la navigazione dell'utente all'interno del sito il più naturale possibile. Il design della pagina è responsive, in particolare sono usati i seguenti breakpoint: 600px e 768px. Per i dispositivi più grandi il contenuto della pagina risulta essere centrato, con una dimensione massima di 1024px. 
Caratteristiche: 
- Il pannello HEADER per dispositivi con width > 768px presenta il titolo del sito e due bottoni per LOGIN/REGISTRAZIONE. A dimensioni inferiori, a tali elementi viene aggiunto un bottone per raggiungere il MENU. 
- Il MENU è visibile come pannello laterale per schermi con width > 768px, per quelli di dimensioni inferiori viene spostato sotto al pannello principale della pagina. Il menu risulta essere raggiungibile: o premendo il tasto "MENU" che compare nell'header o una volta scorso tutto il pannello principale. Questa scelta permette di evitare eventuali menu ad humburger e facilita la realizzazione di una pagina più accessibile. 

 
 ## FAQ
La pagina di FAQ presenta DOCTYPE HTML 5, rispettando comunque le regole di sintassi di XHTML 1.0 Strict. 
Questa decisione è dovuta a: 
- Utilizzo dell'attributo tabindex sui dt e dd 

Particolarità della pagina: 
- la pagina funziona correttamente anche nel caso in cui js sia disattivato, in particolare in tale situazione 
	tutte le domande risultaranno "aperte", e saranno quindi già visibili le relative risposte.
- gli utenti possono accedere alle risposte tramite un click sul relativo dt, oppure tramite il tasto "invio" (una 
	volta messo in focus il td). Questa funzionalità richiede la presenza di js attivato, e rende accessibile le pagine 
	anche a utenti impossibilitati all'utilizzo del mouse. 
