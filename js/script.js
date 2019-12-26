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




// ETA' MINIMA PER ISCRIVERSI
const MIN_AGE = 12; 


function login_init() {
    var loginForm = document.getElementById("login_form"); 
    var msgManager = new MsgManager(); 

    if(loginForm) {
        var loginBtn = document.getElementById("login_btn"); 
     
        loginBtn.addEventListener("click", function(e) {
            e.preventDefault(); 

                // rimuovo gli eventuali messaggi
            msgManager.clearAll(); 

            var fUtils = new FormUtils(); 
            var email = document.getElementById("email"); 
            var psw = document.getElementById("password"); 

            var allOK = true; 
            if(fUtils.isEmpty(psw.value)) {
                msgManager.showNew("Inserire una password", psw); 
                allOK = false; 
            }

            if(fUtils.isEmpty(email.value)) {
                msgManager.showNew("Inserire una mail", email); 
                allOK = false; 
            } else if(!fUtils.isEmail(email.value.trim())) {
                msgManager.showNew("La mail inserita non è valida", email); 
                allOK = false;
            }

            return allOK;      
        }); 
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
    
