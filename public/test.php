<?php

class persom{
    public function echo(){
        echo '11';
    }
}

class mark extends persom{
    public function echo($e=null){
        echo '11';
    }
}

(new mark())->echo();