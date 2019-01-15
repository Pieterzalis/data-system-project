<?php
#$command = escapeshellcmd("python C:\\Users\\flori\\OneDrive\\Documenten\\hello.py");
#$output = shell_exec($command);

    // TODO make this dynamic with the upload script!
    $file_path = htmlentities('read_qf.py C:\\xampp\htdocs\\datasystems.test\\Backend\\letter2.pdf');
    $file_name = basename($file_path);

    exec("python " . $file_path . "", $output, $ret_code);
    //echo end($output);

    $output_data = end($output);

    if ($output_data===false) {
        $output_data = null;
        echo 'Python returned no output';
    }
    else {
        $json = json_decode($output_data);
        //echo $json;

// Now decode indiener to only have names and party
        $test = 1;
        echo '<h2>Parse results of letter: '. $file_name .'</h2>';
        echo '<p>Project Code: ' . $json->metadata->id . '</p>';
        echo '<p>Indiener: ' . $json->metadata->indiener . '</p>';
        echo '<p>Topic of projet: ' . $json->metadata->topic . '</p>';
        echo '<p>Date of letter: ' . $json->metadata->date . '</p>';

    }






