## FAQ
La pagina di FAQ presenta DOCTYPE HTML, rispettando comunque le regole di sintassi di XHTML 11.0 Strict. 
Questa decisione è dovuta a: 
- Utilizzo degli attributi data-* introdotti in HTML5 (per gestire i link di APRI_TUTTI, CHIUDI_TUTTI) 
- Utilizzo dell'attributo tabindex sui dt e dd (introdotto anch'esso da HTML5)

Particolarità della pagina: 
- la pagina funziona correttamente anche nel caso in cui js sia disattivato, in particolare in tale situazione 
	tutte le domande risultaranno "aperte", e saranno quindi già visibili le relative risposte 
- gli utenti possono accedere alle risposte tramite un click sul relativo dt, oppure tramite il click del tasto "invio" una 
	volta messo in focus il td. Questa funzionalità richiede la presenza di js attivato, e rende accessibile le pagine 
	anche a utenti impossibilitati all'uso del mouse 
