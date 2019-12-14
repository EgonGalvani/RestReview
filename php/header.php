<?php 

    class pageHeader{
        public $logged;

        public function __construct($log=false){
            $this->logged=$log;
        }

        public function getHeader(){
            $header='<div id="header">
                    <h1 id="title">RestReview</h1>
                    <a id="hamburger" href="#menu" class="a_btn">MENU</a>';
            if($this->logged){
                $header.='<a href="logout_script.php" class="a_btn">ESCI</a>';
            }else{
                $header.='<a href="login.php" class="a_btn" xml:lang="en">LOGIN</a>
                        <a href="registrazione.php" class="a_btn">REGISTRAZIONE</a> ';
            }
            $header.='</div>';
            return $header;
        }
    }

?>