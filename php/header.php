<?php 

    class pageHeader{
        public $logged;

        public function __construct($log=false){
            $this->logged=$log;
        }

        public function getHeader(){
            $header='<h1 id="title">RestReview</h1>
                    <a id="hamburger" href="#menu" class="btn">MENU</a>';
            if($this->logged){
                $header.='<a href="logout_script.php" class="btn">ESCI</a>';
            }else{
                $header.='<a href="login.php" class="btn" xml:lang="en">LOGIN</a>
                        <a href="registrazione.php" class="btn">REGISTRAZIONE</a> ';
            }
            return $header;
        }
    }

?>