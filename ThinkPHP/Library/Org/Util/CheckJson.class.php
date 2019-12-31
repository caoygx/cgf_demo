<?php

class checkJson{

    public $enableWarning=true;
    public $enableNotice=true;

    function check($expectationOfJson,$resultOfJson){
        $expectationOfJson = json_decode($expectationOfJson,true);
        $resultOfJson = json_decode($resultOfJson,true);
        $this->check_ecursive($expectationOfJson,$resultOfJson);
    }


    function check_ecursive($expectationOfJson, $resultOfJson, $prevKey = ''){

        //global $checkResponseErrors,$checkResponseWarning;
        foreach($expectationOfJson as $k => $v) {
            //var_dump($k);
            if(is_array($v)) {
                $this->check_ecursive($v, $resultOfJson[$k], $prevKey . "." . $k);
            } else {
                if(!array_key_exists($k,$resultOfJson)  ) {

                    $fun_return['error_msg'][] = $prevKey.$k."--".var_export($expectationOfJson[$k],1)."--"."   >>>   has error";
                    $this->echo_color("    $prevKey.{$k} : ", "BROWN");
                    $this->echo_color( var_export($expectationOfJson[$k],1), "RED");
                    $this->echo_color("   >>>   has error", "RED");
                    echo "\n";
                    if($v === "not null") {
                        $fun_return['error_msg'][] = "$k 不能为空";
                        //echo "$k 不能为空";
                    }


                }elseif(empty($resultOfJson[$k])){
                    if($this->enableWarning){
                        $fun_return['warning_msg'][] = $prevKey.$k;

                        $this->echo_color("    $prevKey.{$k} : ", "BROWN");/**/
                        echo "waring \n";
                    }

                }
            }
        }
    }




//php命令行下加颜色
    function echo_color($text, $color="NORMAL",$is_backgroud = 0, $back=0){
        $_colors = array(
            'LIGHT_RED'      => "[1;31m",
            'LIGHT_GREEN'     => "[1;32m",
            'YELLOW'     => "[1;33m",
            'LIGHT_BLUE'     => "[1;34m",
            'MAGENTA'     => "[1;35m",
            'LIGHT_CYAN'     => "[1;36m",
            'WHITE'     => "[1;37m",
            'NORMAL'     => "[0m",
            'BLACK'     => "[0;30m",
            'RED'         => "[0;31m",
            'GREEN'     => "[0;32m",
            'BROWN'     => "[0;33m",
            'BLUE'         => "[0;34m",
            'CYAN'         => "[0;36m",
            'BOLD'         => "[1m",
            'UNDERSCORE'     => "[4m",
            'REVERSE'     => "[7m",

        );

        if($is_backgroud){
            $_colors = array(
                "SUCCESS" => "[42m", //Green background
                "FAILURE" => "[41m", //Red background
                "WARNING" => "[43m", //Yellow background
                "NOTE"    => "[44m", //Blue background
            );
        }



        //echo chr(27) . "[0;31m" . "$text" . chr(27) . "[0m";exit;
        $out = $_colors["$color"];
        if($out == ""){ $out = "[0m"; }
        if($back){
            return chr(27).$out.$text.chr(27)."[0m";
        }else{
            echo chr(27).$out.$text.chr(27)."[0m";
            //echo chr(27)."$out$text".chr(27).chr(27)."[0m".chr(27);
        }//fi
    }



}
