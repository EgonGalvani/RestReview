/************************ CODICE PER PAGINA DI BASE ******************************/

// GESTIONE BOTTONE PER TORNARE A INIZIO PAGINA
var scrollBtn = document.getElementById("scrollBtn"); 

// lo scroll massimo è di documentHeight - screenHeight
window.onscroll = function() {
    // valuto se ha senso introdurre il bottone nella pagina (il calcolo del valore limite viene messo 
    // all'interno dell'evento per gestire anche eventuali ridimensionamenti in verticale)
    var LIMIT = window.screen.height * 0.25;

    // mostro il bottone se lo scroll è superiore a una certa soglia (LIMIT)
   /* if(document.body.scrollTop > LIMIT || document.documentElement.scrollTop > LIMIT)
        this.removeClass(scrollBtn, "hide"); 
    else this.addClass(scrollBtn, "hide"); */ 
}; 

/****************** CODICE PER LA PAGINA FAQ.HTML *****************************/

class FaqItem {
    constructor(dtElement) {
        this.dt = dtElement; 
        this.dd = dtElement.nextElementSibling; 
        this.isOpen = true; // di default tutti i faq item sono aperti  

        // setto il click listener e il click del tasto enter 
        // poichè in javascript c'è il concetto di execution context, 
        // mi occupo di fare già il bind dei metodi relativi alla gestione degli eventi
        this.dt.addEventListener("click", this.onClick.bind(this)); 
        this.dt.addEventListener("keyup", function(e) {
            if(e.keyCode === 13) { // ENTER KEY_CODE
                e.preventDefault(); 
                this.onClick(); 
            }
        }.bind(this)); 
    } 

    open() {
        if(!this.isOpen) {
            this.dd.classList.remove("hide"); 
            this.dt.classList.remove("faq_closed"); 
            this.isOpen = true; 
        }
    }

    close() {
        if(this.isOpen) {
            this.dd.classList.add("hide"); 
            this.dt.classList.add("faq_closed"); 
            this.isOpen = false; 
        }
    }

    onClick() {
        if(this.isOpen)
            this.close();
        else 
            this.open(); 
    }
}

class FaqList {
    constructor(listElement) {
        this.listID = listElement.id; 
        this.list = new Array(); 

        // INTRODUCO TUTTI GLI ELEMENTI DELLA LISTA IN UN ARRAY (SOTTOFORMA DI ListItem)
        var dts = listElement.getElementsByTagName("dt"); 
        for(var i = 0; i < dts.length; i++)  {
            this.list.push(new FaqItem(dts[i])); 
        }
    }

    openAll() {
        for(var i = 0; i < this.list.length; i++) {
            this.list[i].open(); 
        } 
    }

    closeAll() { 
        for(var i = 0; i < this.list.length; i++) {    
           this.list[i].close();  
        }
    }

}


/************* CODICE PER LOGIN E REGISTRAZIONE *******/

/** SPIEGAZIONE REGEX PSW 
 * /^
  (?=.*\d)          // should contain at least one digit
  (?=.*[a-z])       // should contain at least one lower case
  (?=.*[A-Z])       // should contain at least one upper case
  [a-zA-Z0-9]{8,}   // should contain at least 8 from the mentioned characters
  $/
*/

MSG_TYPES = {
    ERROR: -1, 
    WARNING: 0, 
    SUCCESS: 1
}; 

class MsgBox {
    constructor(type, msg) {
        this.text = msg; 
        this.type = type;
        this.isShown = false; // default
        
        // creo il box per il messaggio 
        this.box = document.createElement("div");
        this.box.classList.add("msg_box"); 

        var msgClass = "success_box"; 
        if(type == MSG_TYPES.ERROR)
            msgClass = "error_box"; 
        else if(type == MSG_TYPES.WARNING)
            msgClass = "warning_box"; 

        this.box.classList.add(msgClass); 
        this.box.innerHTML = msg;
    }

    show(parent) {
        if(!this.isShown) {
            // se non è presente alcun parent considero di inserire l'elemento come primo 
            // elemento del body 
            if(!parent)
                parent = document.body; 
                
            parent.insertBefore(this.box, parent.firstChild); 
            this.isShown = true; 
        }
    }

    delete() {
        if(this.isShown) {
            // rimuove l'elemento dal DOM 
            this.box.parentNode.removeChild(this.box);
            this.isShown = false; 
        }
    }
}


class FormUtils {
    emailRegex = /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/;
    pswRegex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/; 

    isEmail(email) {
        return new RegExp(this.emailRegex).test(email); 
    }

    isPsw(psw) {
        return new RegExp(this.pswRegex).test(psw); 
    }

    isEmpty(str) { 
        return !str.trim().length; 
    }

    hasNYear(dateValue, yearOld) {
        var today = new Date(); 
        var bDay = new Date(dateValue);
        
        // differenza rispetto al 1970 (unix timestamp)
        var diff =new Date(today - bDay); 
        return diff.getFullYear() >= 1970 + yearOld; 
    }

    equals(str1, str2) {
        return str1.trim() == str2.trim(); 
    }
}



function faq_init() {
    var fLists = document.getElementsByClassName("faq_list"); 
    if(fLists) {
        // instanzio tutte le liste 
        var fListObj = new Array(); 
        for(var i = 0; i < fLists.length; i++)
            fListObj.push(new FaqList(fLists[i])); 

        // chiudo tutte le liste (=> di default sono aperte per permettere ad utenti senza js abilitato 
        // di leggere le risposte ) 
        for(var i = 0; i < fListObj.length; i++) {
            fListObj[i].closeAll(); 
        }

        // gestione dei controlli di apertura e chisura
        // ottengo una lista di tutti i controlli 
        var controls = document.querySelectorAll(".faq_control_close, .faq_control_open"); 
        for(var i = 0; i < controls.length; i++) {
            
            // setto il click listener di ogni controllo 
            controls[i].addEventListener("click", function() {
                
                // identifico la lista a cui fa riferimento e la cerco tra le FaqList
                var targetListID = this.getAttribute("href").substr(1);   
                for(var j = 0; j < fListObj.length; j++) {

                    // quando trovo la FaqList di interesse agisco in base al tipo di control
                    if(targetListID == fListObj[j].listID) {
                        if(this.classList.contains("faq_control_close"))
                            fListObj[j].closeAll(); 
                        else fListObj[j].openAll(); 
                    }
                }
            });
        }
    }
}

// ETA' MINIMA PER ISCRIVERSI
const MIN_AGE = 12; 

// MESSAGGI DI ERRORE
var errorMSGs = {
    "empty_email" : new MsgBox(MSG_TYPES.ERROR, "Inserire una email!"), 
    "empty_password": new MsgBox(MSG_TYPES.ERROR, "Inserire una password!"), 
    "wrong_email": new MsgBox(MSG_TYPES.ERROR, "L'email inserita non è valida!"), 
    "wrong_password" : new MsgBox(MSG_TYPES.ERROR, "La password deve avere una lunghezza minima di 8 caratteri. Può contenere lettere e numeri. Deve contenere almeno: una lettere maiuscola, una lettera minuscola e una cifra!"), 
    "psw_match": new MsgBox(MSG_TYPES.ERROR, "La password e la relativa ripetizione non coincidono!"), 
    "empty_fields" : new MsgBox(MSG_TYPES.ERROR, "Tutti i campi devono essere riempiti!"), 
    "too_young": new MsgBox(MSG_TYPES.ERROR, "Ci dispiace ma, per il regolamento, l'età minima è di " + MIN_AGE + " anni.")
}; 

function login_init() {
    var loginForm = document.getElementById("login_form"); 
    if(loginForm) {
        var loginBtn = document.getElementById("login_btn"); 
     
        // se ci sono eventuali messaggi di errore, li mostro come figli del 
        // fieldset 
        var msgsParent = loginForm.firstElementChild; 

        loginBtn.addEventListener("click", function(e) {
            e.preventDefault(); 
            
            // rimuovo gli eventuali messaggi
            for (var key in errorMSGs) {
                errorMSGs[key].delete(); 
            }

            var fUtils = new FormUtils(); 
            var email = document.getElementById("email"); 
            var psw = document.getElementById("password"); 

            var allOK = true; 
            if(fUtils.isEmpty(psw.value)) {
                errorMSGs['empty_password'].show(msgsParent); 
                allOK = false; 
            }

            if(fUtils.isEmpty(email.value)) {
                errorMSGs['empty_email'].show(msgsParent); 
                allOK = false; 
            } else if(!fUtils.isEmail(email.value.trim())) {
                errorMSGs['wrong_email'].show(msgsParent); 
                allOK = false;
            }

            if(allOK) {
                loginForm.submit(); 
            }      
        }); 
    } 
} 

// crea una preview dell'immagine caricata tramite il "sourceElement" 
// in "previewElement"
function imgPreview(sourceElement, previewElement) {
    if(sourceElement.files && sourceElement.files[0]) {
        var reader = new FileReader(); 
        reader.onload = function(ee) {
            previewElement.src = ee.target.result;
        }
        reader.readAsDataURL(sourceElement.files[0]);
    }
}

function reg_init() {
    var reg_form = document.getElementById("form_registrazione"); 
    if(reg_form) {
        
        // preview dell'immagine
        var fileInput = document.getElementById("img_profilo"); 
        fileInput.addEventListener("change", function(e) {
            imgPreview(this, document.getElementById("img_profilo_preview"));
        }); 

        // setto il click listener
        var reg_btn = document.getElementById("reg_btn"); 
        reg_btn.addEventListener("click", function (e) {
            e.preventDefault(); 

            // rimuovo gli eventuali messaggi
            for (var key in errorMSGs) {
                errorMSGs[key].delete(); 
            }

            var reg_fieldset = reg_form.firstElementChild; 

            var email = document.getElementById("email").value; 
            var name = document.getElementById("nome").value; 
            var surname = document.getElementById("cognome").value; 
            var psw = document.getElementById("password").value; 
            var rpsw = document.getElementById("repeatpassword").value; 
          
            var ristoratore = document.getElementById("ristoratore").value;
            var piva = document.getElementById("piva").value;
            var rsoc = document.getElementById("rsoc").value; 
    
            var dNascita = document.getElementById("nascita").value; 
            
            var fUtils = new FormUtils(); 
            var allOk = true; 

            if(fUtils.isEmpty(name) || fUtils.isEmpty(surname) || fUtils.isEmpty(psw) 
                || fUtils.isEmpty(rpsw) || fUtils.isEmpty(dNascita)) {
                
                errorMSGs['empty_fields'].show(reg_fieldset); 
                allOk = false; 
            } else if(ristoratore.checked && (fUtils.isEmpty(piva) || fUtils.isEmpty(rsoc)) ) {
                errorMSGs['empty_fields'].show(reg_fieldset); 
                allOk = false; 
            } 

            if(allOk) {
                if(!fUtils.isEmail(email)) {
                    errorMSGs['wrong_email'].show(reg_fieldset); 
                    allOk = false; 
                }

                if(!fUtils.isPsw(psw)) {
                    errorMSGs['wrong_password'].show(reg_fieldset); 
                    allOk = false; 
                } else if(!fUtils.equals(psw, rpsw)) {
                    errorMSGs['psw_match'].show(reg_fieldset); 
                    allOk = false; 
                }

                if(!fUtils.hasNYear(dNascita, MIN_AGE)) {
                    errorMSGs['too_young'].show(reg_fieldset); 
                    allOk = false; 
                } 
            }

            if(allOk) {
                reg_form.submit(); 
            }
        }); 
    }
}

/***************CODICE PAGINA PROFILO *****************/

function profile_init(){

    var prof_form = document.getElementById("modifica_dati");
    if(prof_form){
        var fileInput = document.getElementById("new_foto_profilo");
        fileInput.addEventListener("change", function(e) {
            imgPreview(this, document.getElementById("img_profilo"));
        });
    }
}

window.onload = function() {

    // ----------- FAQ  ---------------
    faq_init(); 

    // ------------- LOGIN ---------------
    login_init();

    // ---------- REGISTRAZIONE -------------- 
    reg_init(); 

    // ----------- PROFILO ---------------
    profile_init()
}; 
    
