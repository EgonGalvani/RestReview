
// CODICE PER FAQ 

// util functions 
function addClass(element, className) {
    if(element && !element.classList.contains(className))
        element.classList.add(className); 
}

function removeClass(element, className) {
    if(element && element.classList.contains(className))
        element.classList.remove(className); 
}

function getTargetDDs(control) {
    if(control) {
        var target = document.getElementById(control.getAttribute("data-target")); 
        return target.getElementsByTagName("dd"); 
    }

    return []; 
}

function closeAll(close_control) {
    var dds = getTargetDDs(close_control); 
    for(var i = 0; i < dds.length; i++) {
        addClass(dds[i], "hide"); 
    }
}

function openAll(open_control) {
    var dds = getTargetDDs(open_control); 
    for(var i = 0; i < dds.length; i++) {
        removeClass(dds[i], "hide"); 
    }
}

// click listeners 
function faqClickListener(e) {
    var dd = e.target.nextElementSibling; 

    if(dd) {
        if(dd.classList.contains("hide"))
            removeClass(dd, "hide"); 
        else 
            addClass(dd, "hide"); 
    }
}

// operazioni base di apertura dt/dd e inizializzazione a chiuso 
var dts = document.getElementsByTagName("dt"); 
for(var i = 0; i < dts.length; i++) {
    addClass(dts[i].nextElementSibling, "hide"); 
    dts[i].addEventListener("click", faqClickListener); 
}

// controlli di chiusura 
var closeControls = document.getElementsByClassName("faq_close"); 
for(var i = 0; i < closeControls.length; i++) {
    closeControls[i].addEventListener("click", (e) => closeAll(e.target)); 
}

// controlli di apertura 
var openControls = document.getElementsByClassName("faq_open"); 
for(var i = 0; i < openControls.length; i++) {
    openControls[i].addEventListener("click", (e) => openAll(e.target)); 
}