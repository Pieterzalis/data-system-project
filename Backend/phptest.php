<?php
#$command = escapeshellcmd("python C:\\Users\\flori\\OneDrive\\Documenten\\hello.py");
#$output = shell_exec($command);

// TODO make this dynamic with the upload script!
    $file_path = htmlentities('C:\\Users\\Christian\\Desktop\\xampp\\htdocs\\datasystems.test\\Backend\\read_qf.py C:\\Users\\Christian\\Desktop\\xampp\\htdocs\\datasystems.test\\Backend\\letter.pdf');

    exec("python " . $file_path . "", $output, $ret_code);
    echo end($output);

    if (!isset($output[6])) {
        $output[6] = null;
    }

    $test = 1;
    $json = json_decode($output[6]);

// Now decode indiener to only have names and party
    $test = 1;

    echo $json->metadata->id;
#echo $ret_code;




