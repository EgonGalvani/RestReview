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

    getListID() { return this.listID; }
}

class FaqControl {

    // si considera che list sia un oggetto di tipo FaqList
    constructor(element, list) {
        this.element = element; 
        this.list = list;

        // a seconda di che classe ha, vedo se il controllo considerato deve 
        // aprire o chiudere una FaqList 
        this.hasToOpen = element.classList.contains("faq_control_open");   

        // setto il click listener 
        this.element.addEventListener("click", this.onClick.bind(this)); 
    }

    onClick(e) {
        e.preventDefault();

        if(this.hasToOpen) 
            this.list.openAll(); 
        else 
            this.list.closeAll(); 
    }
}


/************* CODICE PER LOGIN E REGISTRAZIONE *******/

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