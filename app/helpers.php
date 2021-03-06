<?php
  function compute_discount($discount,$total_amount,$process){    
    return ($discount / 100 ) * ($total_amount + $process);
  }

  function imploadValue($types){
    $strTypes = implode(",", $types);
    return $strTypes;
  }
 
  function explodeValue($types){
    $strTypes = explode(",", $types);
    return $strTypes;
  }
 
  function random_code()
  {      	 
     return rand(22, 99999999);
  }
  
  function remove_special_char($text) {
 
        $t = $text;
 
        $specChars = array(
            ' ' => '-',    '!' => '',    '"' => '',
            '#' => '',    '$' => '',    '%' => '',
            '&amp;' => '',    '\'' => '',   '(' => '',
            ')' => '',    '*' => '',    '+' => '',
            ',' => '',    '₹' => '',    '.' => '',
            '/-' => '',    ':' => '',    ';' => '',
            '<' => '',    '=' => '',    '>' => '',
            '?' => '',    '@' => '',    '[' => '',
            '\\' => '',   ']' => '',    '^' => '',
            '_' => '',    '`' => '',    '{' => '',
            '|' => '',    '}' => '',    '~' => '',
            '-----' => '-',    '----' => '-',    '---' => '-',
            '/' => '',    '--' => '-',   '/_' => '-',   
             
        );
 
        foreach ($specChars as $k => $v) {
            $t = str_replace($k, $v, $t);
        }
 
        return $t;
  }