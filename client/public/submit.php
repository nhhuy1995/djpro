<?php
if ($_GET['test_curl'] == '123') {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL,"http://s2.download.stream.djscdn.com/check");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS,
            "postvar1=value1&postvar2=value2&postvar3=value3");

// in real life you should use something like:
// curl_setopt($ch, CURLOPT_POSTFIELDS,
//          http_build_query(array('postvar1' => 'value1')));

// receive server response ...
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $server_output = curl_exec ($ch);

    curl_close ($ch);
    echo $server_output;
} else echo 'WTF';

?>