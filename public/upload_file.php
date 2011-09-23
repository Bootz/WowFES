<?php
function random_gen($length) {
    $random= "";
    srand((double)microtime()*1000000);
    $char_list = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $char_list .= "abcdefghijklmnopqrstuvwxyz";
    $char_list .= "1234567890";
    // Add the special characters to $char_list if needed

    for($i = 0; $i < $length; $i++)
    {
         $random .= substr($char_list,(rand()%(strlen($char_list))), 1);
    }
    return $random;
}

// 400000 = 120KB
$maxfilesize = 120 * 1024;

@session_start();
if (isset($_SESSION['username']) && $_FILES['uploadfile']['tmp_name'] !== '' && $_FILES['uploadfile']['size'] <= $maxfilesize && $_FILES['uploadfile']['error'] === 0) {

    $file_type = $_FILES['uploadfile']['type'];
    if ($file_type === 'image/gif' || $file_type === 'image/jpeg' || $file_type === 'image/png' || $file_type === 'image/jpg') {
        $current_date = date ('YmdHis');

        $uploaddir = './uploads/';
        $rand_string = random_gen(32);
        $file = $uploaddir . $current_date . $rand_string . basename($_FILES['uploadfile']['name']);

        if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $file)) {
            $_SESSION['upload_image_url'] = '/uploads/' . $current_date. $rand_string . basename($_FILES['uploadfile']['name']);
            echo $_SESSION['upload_image_url'];
        }
        else {
            echo "error";
        }
    }
}
else {
    exit;
}
?>
