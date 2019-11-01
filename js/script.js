
// CODICE PER FAQ 

//Codice registrazione

function sel_reg(){
        var x = document.getElementById("sel_regid").value;
        if(x=="recensore"){
            document.getElementById("piva_l").classList.add('hidden');
            document.getElementById("piva").classList.add('hidden');
        }
        else{
            document.getElementById("piva_l").classList.remove('hidden');
            document.getElementById("piva").classList.remove('hidden');
        }
        
}

// util functions 

function hasClass(element, className) {
    if(element && element.classList.contains(className))
        return true; 
    return false; 
}

function addClass(element, className) {
    if(element && !element.classList.contains(className))
        element.classList.add(className); 
}

function removeClass(element, className) {
    if(element && element.classList.contains(className))
        element.classList.remove(className); 
}

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

// click listeners 
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

// controlli di chiusura 
var closeControls = document.getElementsByClassName("faq_control_close"); 
for(var i = 0; i < closeControls.length; i++) {
    closeControls[i].addEventListener("click", (e) => modifyAll(e.target, true)); 
}

// controlli di apertura 
var openControls = document.getElementsByClassName("faq_control_open"); 
for(var i = 0; i < openControls.length; i++) {
    openControls[i].addEventListener("click", (e) => modifyAll(e.target, false)); 
}