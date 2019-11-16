
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

function isEmpty(str) { return !str.trim().length; }

/************************ CODICE PER PAGINA DI BASE ******************************/

// GESTIONE BOTTONE PER TORNARE A INIZIO PAGINA
var scrollBtn = document.getElementById("scrollBtn"); 

// lo scroll massimo è di documentHeight - screenHeight
window.onscroll = function() {
    // valuto se ha senso introdurre il bottone nella pagina (il calcolo del valore limite viene messo 
    // all'interno dell'evento per gestire anche eventuali ridimensionamenti in verticale)
    var LIMIT = window.screen.height * 0.25;

    // mostro il bottone se lo scroll è superiore a una certa soglia (LIMIT)
    if(document.body.scrollTop > LIMIT || document.documentElement.scrollTop > LIMIT)
        this.removeClass(scrollBtn, "hide"); 
    else this.addClass(scrollBtn, "hide"); 
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

/************* CODICE PER LOGIN E REGISTRAZIONE *******/
var emailRegex = /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/;
var pswRegex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/; 

/** SPIEGAZIONE REGEX PSW 
 * /^
  (?=.*\d)          // should contain at least one digit
  (?=.*[a-z])       // should contain at least one lower case
  (?=.*[A-Z])       // should contain at least one upper case
  [a-zA-Z0-9]{8,}   // should contain at least 8 from the mentioned characters
  $/
*/

// inserisce un box di errore come primo elemento del fieldset del form
function showErrMsg(form, msg) {
    var fieldset = form.firstElementChild; 
 
    var box = document.createElement("div");
    box.classList.add("error_box"); 
    box.innerHTML = msg; 
    fieldset.insertBefore(box, fieldset.firstChild); 
}

function clearErrMsgs() {
    var errors = document.getElementsByClassName("error_box");  
    while (errors.length > 0) { 
        // ogni volta che rimuovo un elmento dal DOM, viene rimosso anche dall'array
        errors[0].parentNode.removeChild(errors[0]);
    }
}

var loginForm = document.getElementById("login_form"); 
if(loginForm) {
    var email = document.getElementById("email"); 
    var psw = document.getElementById("password"); 
    var loginBtn = document.getElementById("login_btn"); 

    loginBtn.addEventListener("click", function(e) {
        e.preventDefault(); 
        clearErrMsgs(loginForm); 

        var allOK = true; 
       
        if(isEmpty(psw.value)) {
            showErrMsg(loginForm, "Inserire una password!"); 
            allOK = false; 
        }

        var emailPattern = new RegExp(emailRegex); 
        if(!emailPattern.test(email.value.trim())) {
            showErrMsg(loginForm, "Inserire una email valida!"); 
            allOK = false; 
        }

        if(allOK) {
            loginForm.submit(); 
        }      
    }); 

} 