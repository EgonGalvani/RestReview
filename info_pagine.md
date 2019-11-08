## BASE 
La pagina base.html rappresenta la scheletro delle altre pagine. Viene utilizzata una struttura a tre pannelli per rendere la navigazione dell'utente all'interno del sito il più naturale possibile. Il design della pagina è responsive, in particolare sono usati i seguenti breakpoint: 600px e 768px. Per i dispositivi più grandi il contenuto della pagina risulta essere centrato, con una dimensione massima di 1024px. 
Caratteristiche: 
- Il pannello HEADER per dispositivi con width > 768px presenta il titolo del sito e due bottoni per LOGIN/REGISTRAZIONE. A dimensioni inferiori, a tali elementi viene aggiunto un bottone per raggiungere il MENU. 
- Il MENU è visibile come pannello laterale per schermi con width > 768px, per quelli di dimensioni inferiori viene spostato sotto al pannello principale della pagina. Il menu risulta essere raggiungibile: o premendo il tasto "MENU" che compare nell'header o una volta scorso tutto il pannello principale. Questa scelta permette di evitare eventuali menu ad humburger e facilita la realizzazione di una pagina più accessibile. 

 
 ## FAQ
La pagina di FAQ presenta DOCTYPE HTML, rispettando comunque le regole di sintassi di XHTML 1.0 Strict. 
Questa decisione è dovuta a: 
- Utilizzo dell'attributo tabindex sui dt e dd 
- Meta tag viewport, per un supporto più adeguato del responsive design 

Particolarità della pagina: 
- la pagina funziona correttamente anche nel caso in cui js sia disattivato, in particolare in tale situazione 
	tutte le domande risultaranno "aperte", e saranno quindi già visibili le relative risposte.
- gli utenti possono accedere alle risposte tramite un click sul relativo dt, oppure tramite il tasto "invio" (una 
	volta messo in focus il td). Questa funzionalità richiede la presenza di js attivato, e rende accessibile le pagine 
	anche a utenti impossibilitati all'utilizzo del mouse. 
	
## INDEX 
La pagina di FAQ presenta DOCTYPE HTML, rispettando comunque le regole di sintassi di XHTML 1.0 Strict. 
Questa decisione è dovuta a: 
- Utilizzo di placeholder e required 
- Meta tag viewport, per un supporto più adeguato del responsive design 

Particolarità della pagina: 
- Poichè il cambiamento del placeholder è gestito tramite javascript, la disabilitazione di quest'ultimo porta 
	alla mancanza del placeholder stesso dalla barra di ricerca. Questo comportamento risulta più adeguato di inserire il 
	placeholder direttamente nell'html, poichè in questo caso (e in assenza di js abiitato) il placeholder non cambierebbe 			dinamicamente, e porterebbe a una certa ambiguità nella struttura della pagina. 
