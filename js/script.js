/* UTILS */ 

function hasClass(element, className) { return element.classList.contains(className); }

function removeClass(element, className) { element.classList.remove(className); }

function addClass(element, className) { element.classList.add(className); }


/** FAQ */

function openAll(listElement) {
    var dtElements = listElement.getElementsByTagName("dt"); 
    for(var i = 0; i < dtElements.length; i++)
        openDT(dtElements[i]); 
}

function closeAll(listElement) {
    var dtElements = listElement.getElementsByTagName("dt"); 
    for(var i = 0; i < dtElements.length; i++)
        closeDT(dtElements[i]); 
}

function dtClick(dtElement) {
    if(hasClass(dtElement, "faq_closed"))
        openDT(dtElement); 
    else closeDT(dtElement); 
}

function openDT(dtElement) {
    removeClass(dtElement, "faq_closed"); 
    removeClass(dtElement.nextElementSibling, "hide"); 
}

function closeDT(dtElement) {
    addClass(dtElement, "faq_closed"); 
    addClass(dtElement.nextElementSibling, "hide"); 
}


function faq_init() {
    var faqDTs = document.querySelectorAll(".faq_list dt"); 
    for(var i = 0; i < faqDTs.length; i++) {
        faqDTs[i].addEventListener("click", (e) => dtClick(e.target)); 
        closeDT(faqDTs[i]); 
    }

    var closeControls = document.getElementsByClassName("faq_control_close"); 
    for(var i = 0; i < closeControls.length; i++) {
        closeControls[i].addEventListener("click", function(e) {
            e.preventDefault(); 
            closeAll( document.getElementById(e.target.getAttribute("href").substr(1) ) ); 
        });  
    }
    
    var openControls = document.getElementsByClassName("faq_control_open"); 
    for(var i = 0; i < openControls.length; i++) {
        openControls[i].addEventListener("click", function(e) {
            e.preventDefault(); 
            openAll( document.getElementById(e.target.getAttribute("href").substr(1) ) ); 
        });  
    }
}


/** GESTIONE DEI CONTROLLI SU CAMPI DI INPUT */
MSG_TYPES = {
    ERROR: -1, 
    WARNING: 0, 
    SUCCESS: 1
}; 

function createHTMLBox(msg, type) {
    var box = document.createElement("div");
    box.classList.add("msg_box"); 

    var msgClass = "success_box"; 
    if(type == MSG_TYPES.ERROR)
        msgClass = "error_box"; 
    else if(type == MSG_TYPES.WARNING)
        msgClass = "warning_box"; 

    box.classList.add(msgClass); 

    var textNode = document.createTextNode(msg); 
    box.appendChild(textNode); 
    
    return box; 
}

function showAlertBox(element, msg) {
    var box = createHTMLBox(msg, MSG_TYPES.ERROR); 
    element.parentNode.insertBefore(box, element); 
}

function removePreviousBox(element) {
    var prevElement = element.previousElementSibling; 
    if(hasClass(prevElement, "msg_box"))
        prevElement.parentNode.removeChild(prevElement); 
}

function isEmail(email) {
    return new RegExp(/^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/).test(email); 
}

function isPsw(psw) {
    return new RegExp(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/).test(psw); 
}

function isNotEmpty(str) { 
    return str && str.trim().length > 0; 
}

function has12Year(dateValue) {
    var today = new Date(); 
    var bDay = new Date(dateValue);
    
    // differenza rispetto al 1970 (unix timestamp)
    var diff =new Date(today - bDay); 
    return diff.getFullYear() >= 1970 + 12; 
}

function equals(str1, str2) {
    return str1.trim() == str2.trim(); 
}

function addFocusEvents(fields) {

     // per ogni campo 
     for( field in fields ) {

        var fieldElement = document.getElementById(field); 

        // quando il campo acquista il focus, rimuovo gli errori che erano presenti  
        fieldElement.addEventListener("focusin", (e) => removePreviousBox(e.target));

        // quando il campo perde il focus vengono eseguiti i vari controlli 
        fieldElement.addEventListener("focusout", function(e) {

            // controlli relativi al campo attuale 
            var fieldControls = fields[e.target.id]; 
            
            for(var i = 0; i < fieldControls.length; i++) {

                // mostro il messaggio di errore del primo controllo non rispettato 
                if(!fieldControls[i][0](e.target.value)) {
                    showAlertBox(e.target, fieldControls[i][1]); 
                    break; 
                }
            }
        } ); 
    }

}

function executeControls(fields) {

    var allOK = true; 

    // per ogni campo 
    for( field in fields ) {

        // campo da controllare
        var currentField = document.getElementById(field); 

        // elimino eventuali errori 
        removePreviousBox(currentField); 

        // controlli relativi a quel campo 
        var currentFieldControls = fields[field]; 
        
        // per ogni controllo relativo a quel campo 
        for(var i = 0; i < currentFieldControls.length; i++) {

            // controllo se il campo lo rispetta, e in caso negativo mostro un messaggio di errore
            if(!currentFieldControls[i][0](currentField.value)) {
                allOK = false;
                showAlertBox(currentField, currentFieldControls[i][1]); 
                break; 
            } 
        }
    }

    // ritorno TRUE sse i valori di TUTTI i campi rispettano i relativi controlli 
    return allOK; 
}

function login_init() {
    
    if(document.getElementById("login_form")) {

        var loginControls = {}; 
        loginControls["email"] = [ [isEmail, "Inserire una e-mail valida. "] ]; 
        loginControls["password"] = [ [isNotEmpty, "Inserire una password. " ] ];

        addFocusEvents(loginControls); 

        var loginBtn = document.getElementById("login_btn"); 
        loginBtn.addEventListener("click", (e) => { if(!executeControls(loginControls)) e.preventDefault();} );  
    }
}

/*
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
*/
/***************CODICE PAGINA PROFILO *****************/
/*
function profile_init(){

    var prof_form = document.getElementById("modifica_dati");
    if(prof_form){
        var fileInput = document.getElementById("new_foto_profilo");
        fileInput.addEventListener("change", function(e) {
            imgPreview(this, document.getElementById("img_profilo"));
        });
    }
}*/

window.onload = function() {

    // ----------- FAQ  ---------------
    faq_init(); 

    // ------------- LOGIN ---------------
    login_init();

    // ---------- REGISTRAZIONE -------------- 
   // reg_init(); 

    // ----------- PROFILO ---------------
  //  profile_init()
}; 
    
