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


/************* CODICE PER LOGIN E REGISTRAZIONE *******/

MSG_TYPES = {
    ERROR: -1, 
    WARNING: 0, 
    SUCCESS: 1
}; 

class MsgManager {

    showNew(msg, elementAfter, type = MSG_TYPES.ERROR) {
        var htmlBox = this.createHTMLBox(msg, type); 
        
        elementAfter.parentNode.insertBefore(htmlBox, elementAfter);
    }

    createHTMLBox(msg, type) {
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

    clearAll() {
        var boxes = document.getElementsByClassName("msg_box"); 
        if(boxes) {
            for(var i = boxes.length-1; i >= 0; i--)
                boxes[i].parentNode.removeChild(boxes[i]);
        }
    }
}


/** SPIEGAZIONE REGEX PSW 
 * /^
  (?=.*\d)          // should contain at least one digit
  (?=.*[a-z])       // should contain at least one lower case
  (?=.*[A-Z])       // should contain at least one upper case
  [a-zA-Z0-9]{8,}   // should contain at least 8 from the mentioned characters
  $/
*/
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