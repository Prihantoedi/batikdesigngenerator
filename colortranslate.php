<?php 
    function hexToColor($hexadecimal){
        switch($hexadecimal){
            case null:
                $result = null;
                break;
            case "#fcfcfc":
                $result = "Putih";
                break;
            case "#cc8621":
                $result = "Yellow IGK";
                break;
            case "#7f732a":
                $result = "Yellow IRK";
                break;
            case "#b23424":
                $result = "Orange HR";
                break;
            case "#7a5844":
                $result = "Brown IRRD";
                break;
            case "#2e4c66":
                $result = "Blue 04B";
                break;
            case "#434f5b":
                $result = "Grey IRL";
                break;
            case "#2e1836":
                $result = "Violet 14R";
                break;
            case "#d3547b":
                $result = "Rose IR";
                break;
            case "#143d30":
                $result = "Green IB";
                break;
        }

        return $result;
    }

    function colorToHex($color){
        switch($color){
            case null:
                $result = null;
                break;
            case "Putih":
                $result = "#fcfcfc";
                break;
            case "Yellow IGK":
                $result = "#cc8621";
                break;
            case "Yellow IRK":
                $result = "#7f732a";
                break;
            case "#b23424":
                $result = "Orange HR";
                break;
            case "Brown IRRD":
                $result = "#7a5844";
                break;
            case "Blue 04B":
                $result = "#2e4c66";
                break;
            case "Grey IRL":
                $result = "#434f5b";
                break;
            case "Violet 14R":
                $result = "#2e1836";
                break;
            case "Rose IR":
                $result = "#d3547b";
                break;
            case "Green IB":
                $result = "#143d30";
                break;
        }

        return $result;
    }


?>