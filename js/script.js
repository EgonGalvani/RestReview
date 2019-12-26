function faq_init() {
    var fLists = document.getElementsByClassName("faq_list"); 
   
    if(fLists) {
        // instanzio tutte le liste di FAQ
        var fListObj = []; 
        for(var i = 0; i < fLists.length; i++)
            fListObj.push(new FaqList(fLists[i])); 

        // gestione dei controlli di apertura e chisura
        var controls = document.querySelectorAll(".faq_control_close, .faq_control_open");  
        var controlsObjs = []; 

        for(var i = 0; i < controls.length; i++) {

            // associo ad ogni controllo la lista corrispondente

            var refList = fListObj.find( function(element) {
                
                // trovo l'id relativo alla lista 
                var listID = controls[i].getAttribute("href").substr(1); 
            
                return element.getListID() == listID; 
            }); 

            controlsObjs.push(new FaqControl(controls[i],  refList)); 
        }

        // chiudo tutte le liste ( di default sono aperte per permettere ad utenti senza js abilitato 
        // di leggere le risposte ) 
        for(var i = 0; i < fListObj.length; i++) {
            fListObj[i].closeAll(); 
        }
    }
}

/* 
// ETA' MINIMA PER ISCRIVERSI
const MIN_AGE = 12; 

// MESSAGGI DI ERRORE
var errorMSGs = {
    "empty_email" : new MsgBox(MSG_TYPES.ERROR, "Inserire una email!"), 
    "empty_password": new MsgBox(MSG_TYPES.ERROR, "Inserire una password!"), 
    "wrong_email": new MsgBox(MSG_TYPES.ERROR, "L'email inserita non è valida!"), 
    "wrong_password" : new MsgBox(MSG_TYPES.ERROR, "La password deve avere una lunghezza minima di 8 caratteri. Può contenere lettere e numeri. Deve contenere almeno: una lettere maiuscola, una lettera minuscola e una cifra!"), 
    "psw_match": new MsgBox(MSG_TYPES.ERROR, "La password e la relativa ripetizione non coincidono!"), 
    "empty_fields" : new MsgBox(MSG_TYPES.ERROR, "Tutti i campi sono obbligatori!"), 
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

            return allOK;      
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
  //  login_init();

    // ---------- REGISTRAZIONE -------------- 
   // reg_init(); 

    // ----------- PROFILO ---------------
  //  profile_init()
}; 
    
