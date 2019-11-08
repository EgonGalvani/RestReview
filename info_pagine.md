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
	placeholder direttamente nell'html, poichè in questo caso (e in assenza di js abiitato) il placeholder non cambierebbe 			dinamicamente, e porterebbe a una certa ambiguità nella struttura del sito. 
