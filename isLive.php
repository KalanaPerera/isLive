<?php

/*
 * Team XYZ (findmyfare.com)
 * 
 * @original author : https://css-tricks.com/snippets/php/check-if-website-is-available/
 * @updated by kalana perera <kalana.p@findmyfare.com> 
 */



if (isLive('https://www.findmyfare.com')) {
    echo "Up and running!";
} else {
    echo "Woops, nothing found there.";
    sendEmail('abc@somedomain.com','www.findmyfare.com');
}

//returns true, if domain is availible, false if not
function isLive($domain) {
    //check, if a valid url is provided
    if (!filter_var($domain, FILTER_VALIDATE_URL)) {
        return false;
    }

    //initialize curl
    $curlInit = curl_init($domain);
    curl_setopt($curlInit, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curlInit, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($curlInit, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($curlInit, CURLOPT_HEADER, true);
    curl_setopt($curlInit, CURLOPT_NOBODY, true);
    curl_setopt($curlInit, CURLOPT_RETURNTRANSFER, true);

    //get answer
    $response = curl_exec($curlInit);

    curl_close($curlInit);

    if ($response)
        return true;

    return false;
}

function sendEmail($to,$website) {

    $subject  = "Currently ".$website." is down - isLive nofification";
    $message  = "<li>Website : ".$website." </li>";
    $message .= "<li>Status  : down </li>";
    $message .= "<li>Time   : ".date("Y-m-d H:i:s")." </li>";
    $message .= "<p>This email is automatically generated email from isLive App </p>";
    $header   = "From:abc@somedomain.com \r\n";
    $header  .= "MIME-Version: 1.0\r\n";
    $header  .= "Content-type: text/html\r\n";

    $retval = mail($to, $subject, $message, $header);

    return $retval;
}

?>