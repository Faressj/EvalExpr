<?php


function eval_expr(string $expr) {
    $exprarrayy = str_split($expr);
    if ($exprarrayy[0] == "(" && $exprarrayy[count($exprarrayy)-1] == ")") {
        $expr = substr($expr, 1, strlen($expr)-2);
    }
    $p=null;
    while ($p !==1) {
        $parenthese1 = strpos($expr, "(");
        if (!is_int($parenthese1)) {
            $a = now($expr);
            $p = 1;
            return $a . PHP_EOL;
        } else {
            $actualcalcul = prochaincalcul($expr);
            $actualcalcul1 = str_replace("(", "", $actualcalcul);
            $actualcalcul1 = str_replace(")", "", $actualcalcul1);
            $actualcalcul1 = str_replace(".", ",", $actualcalcul1);
            $a = now($actualcalcul1);
            if ($a !== null) {
                $expr = str_replace($actualcalcul, $a, $expr);
            }
            eval_expr($expr);
        }
    }
}

function now($actualcalcul) {
    $result = null;
    $num_arr = array();//  Declare number stack 
    $op_arr = array();//  Declare symbol stack 
    $str = $actualcalcul;
    preg_match_all('/./', $str, $arr);// str to arr

    foreach ($arr as $key => $value) { // prise en compte des float
        foreach ($value as $keys => $values) {
            if ($values == ".") {
                $j = $keys;
                $k = $keys;
                $jj = 0;
                $kk = 0;
                while($jj == 0 && $kk == 0) {
                    if(is_int($value[$j]) && $jj = 0) {
                        $j--;
                    } else {
                        $j++;
                        $jj = 1;
                    }
                    if(is_int($value[$k]) && $kk = 0) {
                        $k++;
                    } else {
                        $k--;
                        $kk = 1;
                    }
                }
            }
        }
    }
    if (isset($j) && isset($k)) { // concatenation des float
        for($x = 1; $x<=$j-$k; $x++) {
            $arr[0][$k].=$arr[0][$k+$x];
        }
    }
    $str_arr = $arr[0];
    $length = count($str_arr);
    $pre_num = '';
    for($i=0; $i<$length; $i++) {
        $val = $str_arr[$i];

        if (is_numeric($val)) {
            $pre_num .= $val;
            if ($i+1>=$length || isOper($str_arr[$i+1])) {
                array_push($num_arr, $pre_num);
                $pre_num = '';
            }

        } else if (isOper($val)) {
            if (count($op_arr)>0) {
                while (end($op_arr) && priority($val) <= priority(end($op_arr))) {
                    calc($num_arr, $op_arr);
                }
            }
            array_push($op_arr, $val);
        }
    }

    while(count($num_arr)>0) {
        calc($num_arr, $op_arr);
        if (count($num_arr)==1) {
            $result = array_pop($num_arr);
            break;
        }
    }
    return $result;
}


function calc(&$num_arr, &$op_arr) { //  fonction de calcul
    if (count($num_arr)>0) {
        $num1 = array_pop($num_arr);
        $num2 = array_pop($num_arr);
        $op = array_pop($op_arr);
        // Ordre des opérations
        if ($op=='*') $re = $num1*$num2;
        if ($op=='/') $re = $num2/$num1;
        if ($op=='%') $re = $num2%$num1;
        if ($op=='+') $re = $num2+$num1;
        if ($op=='-') $re = $num2-$num1;
        array_push($num_arr, $re);
    }
}

function priority($str) { //Trouver la priorité
    if ($str == '*' || $str == '/' || $str == "%") {
        return 1;
    } else {
        return 0;
    }
}

function isOper($oper) { // Si c'est un opérator et non un int
    $oper_array = array('+','-','%','*','/');
    if (in_array($oper, $oper_array)) {
        return true;
    }
    return false;
}

function prochaincalcul($expr) {// Passer au calcul suivant

    $exprarray = str_split($expr);
    $parenthese1 = strpos($expr, "(");
    $nombredechar = count($exprarray);
    $i = 0;
    $z = null;
    $j = $parenthese1;
    while ($z==null) {
        if ($j==$nombredechar) {
            $z = 0;
        }
        if ($exprarray[$j] == ")") {
            $z = $j;
        } elseif ($exprarray[$j] == "(") {
            $parenthese1 = $j;
        }
        $j++;
    }
    $actualcalcul = substr($expr,$parenthese1, $z-$parenthese1+1);
    return $actualcalcul;
}

echo eval_expr($argv[1]);