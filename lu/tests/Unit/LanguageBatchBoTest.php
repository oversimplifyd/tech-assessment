<?php

// you can write to stdout for debugging purposes, e.g.
// print "this is a debug message\n";

function solution($A, $K, $L) {

    $ALen = count($A);
    if (($K + $L) > $ALen) {
        return -1;
    }

    $KMax = 0;
    $KSum = 0;
    $Kindex = 0;

    $LMax = 0;
    $LSum = 0;
    $LIndex = 0;

    for ($i = 0; $i < ($ALen - $K); $i++) {
        for ($j = 0; $j < $K; $j++) {
            $KSum += $A[$j + $i];
        }
        if ($KSum > $KMax) {
            $KMax = $KSum;
            $Kindex = $i;
            $KSum = 0;
        }
    }

    $ASplice = array_splice($A, $Kindex + 1, $K);
    for ($i = 0; $i < ($ASplice - $L); $i++) {
        for ($j = 0; $j < $L; $j++) {
            $LSum += $A[$j + $i];
        }
        if ($LSum > $LMax) {
            $LMax = $LSum;
            $LIndex = $i;
            $LSum = 0;
        }
    }

    return $LMax + $KMax;
    // write your code in PHP7.0
}
