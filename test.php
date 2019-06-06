<?php

    $str[0]  = "A";
    $str[1] = "B";
    $str[2] = "C";

   for($i=0; $i < count($str); $i ++){
            
           $because .= $str[$i].",";
        }
   $because =substr($because ,0 ,-1);
   echo $because;
?>