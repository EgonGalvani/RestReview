<?php
    class errore{

        public $type;

        public function __construct($t){
            $this->type=$t;
        }

        public function errorMsg(){
            switch($this->type){
                case 'DBConnection': return 'Impossibile connettersi al Database';
                case 'query': return 'L\' interrogazione al Database non è andata a buon fine';
                default: return '';
            }
        }

        public function printHTMLerror(){
            return '<p class="msg_box error_box">'.$this->errorMsg().'</p>';
        }

    }

?>