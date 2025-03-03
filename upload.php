<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $correct_password = $_POST['password']; // User-defined password
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES['userfile']['name']);

    echo "<h3>Username: $username</h3>";

    if (move_uploaded_file($_FILES['userfile']['tmp_name'], $target_file)) {
        echo "<h3>File Uploaded Successfully!</h3>";

        $file = fopen($target_file, "r");
        $found = false;
        
        while (($password = fgets($file)) !== false) {
            $password = trim($password);
            if ($password == $correct_password) {
                echo "<h3>Password Found: $password</h3>";
                $found = true;
                break;
            }
        }
        fclose($file);

        if (!$found) {
            echo "<h3>Password Not Found in Dictionary!</h3>";
            echo "<h3>Starting Brute Force Attack...</h3>";
            bruteForce($correct_password);
        }
    } else {
        echo "<h3>File Upload Failed!</h3>";
    }
}

function bruteForce($correct_password) {
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $max_length = 5;
    $found = false;

    for ($i = 0; $i < strlen($characters); $i++) {
        for ($j = 0; $j < strlen($characters); $j++) {
            for ($k = 0; $k < strlen($characters); $k++) {
                for ($l = 0; $l < strlen($characters); $l++) {
                    for ($m = 0; $m < strlen($characters); $m++) {
                        $attempt = $characters[$i] . $characters[$j] . $characters[$k] . $characters[$l] . $characters[$m];
                        if ($attempt == $correct_password) {
                            echo "<h3>Brute Force Password Found: $attempt</h3>";
                            $found = true;
                            break 5;
                        }
                    }
                }
            }
        }
    }

    if (!$found) {
        echo "<h3>Brute Force Attack Failed!</h3>";
    }
}
?>
