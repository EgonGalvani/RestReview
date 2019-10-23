# Struttura delle pagine 
Ogni pagina presenta una struttura a tre pannelli: <br />
![Schema](http://www.abcwebegrafica.altervista.org/crea_il_tuo_sito_web/img/02/schema-grafico-di-un-sito.jpg)

In particolare si possono distinguere 4 componenti principali: 
- Header
- Menu 
- Contenuti 
- Footer 

## Header 
Tale componente presenta Nome e Logo del sito. 
Nel caso di un **utente generico**, e quindi non loggato, all'interno di tale componente sono visibili due bottoni: uno per il Login e 
uno per la Registrazione, che reindirizzano alle relative pagine. 
Nel caso in cui, invece, l'**utente** sia già **loggato**, è mostrato un bottone per il logout. <br />
Essendo un componente dinamico, questo viene creato tramite php e introdotto successivamente all'interno del file html: in questo modo 
viene mantenuta la separazione tra struttura e contenuto. 

## Menu 
Nel menu sono presenti i collegamenti alle varie pagine raggiungibili dall'utente considerato (per maggiori dettagli fare riferimento
alla sezione "Casi d'uso").  Proprio per questo comportamento variabile a seconda della tipologia di utente, anche tale componente è
classificato come dinamico e generato tramite php. 

## Contenuti 
La parte di contenuto vero e proprio varia a seconda della pagina considerata. 

## Footer 
Il footer riporta informazioni generali riguardanti il sito, come: copyright... 
