<?php
    if (isset($_POST['first_name']) && isset($_POST['last_name'])) {
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];

        echo "Привіт, $first_name $last_name!";
    } else {
        echo "Будь ласка, заповніть усі поля.";
    }
?>