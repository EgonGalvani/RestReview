<?php
    class formRistorante{

        public $type;
        public $ristID;

        public function __construct($t,$id){
            $this->type=$t;
            $this->ristID=$id;
        }

        public function getForm(){
            switch($this->type){

                case 'Accetta': {
                    $method='get';
                    $action='';
                    $name='';
                    $value='Accetta';
                    break;
                    }
                case 'Rifiuta':{
                    $method='get';
                    $action='';
                    $name='';
                    $value='Rifiuta';
                    break;
                    }
                case 'Dettaglio':{
                    $method='post';
                    $action='dettaglioristorante.php';
                    $name='visitaRist';
                    $value='Vai al ristorante';
                    break;
                    }
                case 'Elimina':{
                    $method='post';
                    $action='';
                    $name='';
                    $value='Elimina';
                    break;
                    }
            }
            $form="<form method=\"$method\" action=\"$action\" class=\"input_btn_form\">
                        <fieldset>
                            <input type=\"hidden\" name=\"id\" value=\"$this->ristID\">
                            <input type=\"submit\" name=\"$name\" value=\"$value\" />
                        </fieldset>
                    </form>";

            return $form;
        }
    }
?>