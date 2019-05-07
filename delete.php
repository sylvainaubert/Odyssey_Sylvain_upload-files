<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (file_exists('assets/upload/' . $_POST['file_name'])) {
        unlink('assets/upload/' . $_POST['file_name']);
        header('Location: index.php');
    }
}