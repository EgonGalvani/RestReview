<?php
    class formRistorante{

        public $type;
        public $ristID;

        public function __construct($t, $id){
            $this->type = $t;
            $this->ristID = $id;
        }

        public function getForm(){
            switch($this->type){
                case 'Accetta': 
                    $method='post';
                    $action='';
                    $name='';
                    $value='Accetta richiesta';
                    $class='msg_box success_box'; 
                break;
                case 'Rifiuta': 
                    $method='post';
                    $action='';
                    $name='';
                    $value='Rifiuta richiesta';
                    $class='msg_box error_box'; 
                break;
                case 'Dettaglio':
                    $method='get';
                    $action='dettaglioristorante.php';
                    $name='visitaRist';
                    $value='Vai al ristorante';
                    $class=''; 
                break;
                case 'Elimina':
                    $method='post';
                    $action=$_SESSION['current_page'];
                    $name='eliminaRist';
                    $value='Elimina ristorante';
                    $class=''; 
                break;
            }

            $form = "<form method=\"$method\" action=\"$action\">
                        <fieldset>
                            <input type=\"hidden\" name=\"id\" value=\"$this->ristID\" />
                            <input type=\"submit\" name=\"$name\" value=\"$value\" class=\"btn $class\" />
                        </fieldset> 
                    </form>";

            return $form;
        }
    }

    class formRecensione{

        public $type;
        public $recID;
        public $viewerID;

        public function __construct($t,$rec_id,$view_id =''){
            $this->type=$t;
            $this->recID=$rec_id;
            $this->viewerID=$view_id;
        }

        public function getForm(){
            
            switch($this->type){
                case 'Like':
                    $method='post';
                    $action='ins_like.php';
                    $name='submit';
                    $value=''; 
                    $title='Metti mi piace';
                    $class='like_button'; 
                break;
                case 'Dislike':
                    $method='post';
                    $action='remove_like.php';
                    $name='submit';
                    $value='';
                    $title='Togli mi piace.';
                    $class='like_button has_like'; 
                break;
                case 'Elimina':
                    $method='post';
                    $action='';
                    $name='submit';
                    $value='Elimina recensione';
                    $class='btn'; 
                    $title=''; 
                break;
            }

            $form = "<form method=\"$method\" action=\"$action\">
                        <fieldset>
                            <input type=\"hidden\" name=\"ID_Recensione\" value=\"$this->recID\" />
                            <input type=\"hidden\" name=\"ID_Viewer\" value=\"$this->viewerID\" />
                            <input type=\"submit\" name=\"$name\" title=\"$title\" value=\"$value\" class=\"$class\" />
                        </fieldset> 
                    </form>";

            return $form;
        }
    }
?>