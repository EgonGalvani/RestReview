
/** FUNZIONI UTILI  */

// ritorna true sse l'elemento element presenta la classe avente nome className
function hasClass(element, className) {
    if(element && element.classList.contains(className))
        return true; 
    return false; 
}

// aggiunge la classe className all'elemento element
function addClass(element, className) {
    if(element && !element.classList.contains(className))
        element.classList.add(className); 
}

// rimuove la classe className all'elemento element
function removeClass(element, className) {
    if(element && element.classList.contains(className))
        element.classList.remove(className); 
}

// funzione per avere uno smooth scroll da un elemento all'altro 
function scrollTo(element, to, duration) { 
    if (duration <= 0) return;
    var difference = to - element.scrollTop;
    var perTick = difference / duration * 10;
    
    setTimeout(function() {
        element.scrollTop = element.scrollTop + perTick;
        if (element.scrollTop === to) return;
        scrollTo(element, to, duration - 10);
    }, 10); 
}

/************************ CODICE PER PAGINA DI BASE ******************************/

// GESTIONE CLICK SU HAMBURGER 
var hamburger = document.getElementById("hamburger"); 
var hTargetID = hamburger.getAttribute("href").substr(1); // rimuovo il # dall'href ==> ottengo l'id 
// elmento a cui bisogna arrivare quando l'hamburger viene cliccato 
var hTarget = document.getElementById(hTargetID); 
/*
hamburger.addEventListener("click", function(e) {
    e.preventDefault(); 
    scrollTo(document.documentElement, hTarget.offsetTop, 300); 
}); */

// GESTIONE BOTTONE PER TORNARE A INIZIO PAGINA
var screenHeight = window.screen.height; 
var documentHeight = document.documentElement.scrollHeight; 
var scrollBtn = document.getElementById("scrollBtn"); 

// lo scroll massimo è di documentHeight - screenHeight

const LIMIT = screenHeight * 0.25; 
window.onscroll = function() {
    // valuto se ha senso introdurre il bottone nella pagina (il controllo viene messo all'interno 
    // dell'evento per gestire anche eventuali ridimensionamenti in verticale)
    if(documentHeight > screenHeight*1.5) { 

        // mostro il bottone se lo scroll è superiore a una certa soglia (LIMIT)
        if(document.body.scrollTop > LIMIT || document.documentElement.scrollTop > LIMIT)
            this.removeClass(scrollBtn, "hide"); 
        else 
            this.addClass(scrollBtn, "hide"); 
    }
}; 




/****************** CODICE PER LA PAGINA FAQ.HTML *****************************/

// control = elemento di controllo delle faq (cioè un link "apri tutte", "chiudi tutte")
// ritorna un oggetto avente come attributi due vettori, contenenti dd e dt 
// della lista di domande a cui si riferisce il control specificato 
function getTargetDetails(control) {
    if(control) {
        var targetId = control.getAttribute("href").substr(1); // rimuovo il # 
        var target = document.getElementById(targetId); 
        return {
            dts: target.getElementsByTagName("dt"),
            dds: target.getElementsByTagName("dd")
        }; 
    }

    return {dts: [], dds: []}; 
}

// apre/chiude tutte le domande gestite da un determinato control
function modifyAll(control, close) {
    var info = getTargetDetails(control); 
          
    for(var i = 0; i < info.dts.length; i++) {
        if(close) {
            addClass(info.dts[i], "faq_closed"); 
            addClass(info.dds[i], "hide"); 
        } else {
            removeClass(info.dts[i], "faq_closed"); 
            removeClass(info.dds[i], "hide");   
        }
    }   
}

// click listener per un elemento della lista di domande, se la domanda 
// che è stata cliccata è gia aperta, allora viene chiusa. Altrimenti accade il contrario. 
function faqClickListener(e) {
    var dt = e.target; 
    if(hasClass(dt, "faq_closed"))
        removeClass(dt, "faq_closed"); 
    else addClass(dt, "faq_closed"); 

    var dd = dt.nextElementSibling; 
    if(hasClass(dd, "hide"))
        removeClass(dd, "hide"); 
    else addClass(dd, "hide"); 
}

var dts = document.getElementsByTagName("dt"); 
if(dts) {
    for(var i = 0; i < dts.length; i++) {
        // chiudo tutte le faq => in questo modo se js è disabilitato l'utente
        // è comunque in grado di visualizzare le risposte 
        addClass(dts[i].nextElementSibling, "hide"); 
        addClass(dts[i], "faq_closed"); 

        // setto i listener per l'evento click del mouse 
        // e enter button 
        dts[i].addEventListener("click", faqClickListener); 
        dts[i].addEventListener("keyup", function(e) {
            if(e.keyCode === 13) { // ENTER KEY_CODE
                e.preventDefault(); 
                faqClickListener(e); 
            }
        }); 
    }
}

// controlli di chiusura 
var closeControls = document.getElementsByClassName("faq_control_close"); 
if(closeControls) {
    for(var i = 0; i < closeControls.length; i++) {
        closeControls[i].addEventListener("click", (e) => modifyAll(e.target, true)); 
    }
}

// controlli di apertura 
var openControls = document.getElementsByClassName("faq_control_open"); 
if(openControls) {
    for(var i = 0; i < openControls.length; i++) {
        openControls[i].addEventListener("click", (e) => modifyAll(e.target, false)); 
    }
}