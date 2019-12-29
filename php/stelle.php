<?php
    class stelle{

        public $numero;

        public function __construct($num){
            $this->numero=$num;
        }

        function printStars(){
            if($this->numero<0 || $this->numero>5){
                return "";
            }
            $stelle="";
            for($i=1;$i<=$this->numero;$i++){
                $stelle.="&#9733;";
            }
            for($i=5;$i>$this->numero;$i--){
                $stelle.="&#9734;";
            }
            return $stelle;
        }
    }

?>