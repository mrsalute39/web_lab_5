<?php
session_start();
$username = htmlspecialchars($_POST['username']);
$age = htmlspecialchars($_POST['age'] ?? '');
$theme = htmlspecialchars($_POST['theme'] ?? '');
$prize = isset($_POST['prize']) ? 1 : 0;
$difficulty = htmlspecialchars($_POST['difficulty'] ?? '');

$errors = [];
if (empty($username)) {
    $errors[] = "Имя не может быть пустым";
}
if (!filter_var($age, FILTER_VALIDATE_INT)) {
    $errors[] = "Неверно указан возраст";
}
if (empty($theme)) {
    $errors[] = "Тема должна быть выбрана";
}
if (empty($difficulty)) {
    $errors[] = "Выберите сложность";
}

if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    header("Location: index.php");
    exit();
}

require_once 'ApiClient.php';
$api = new ApiClient();

$url = 'https://opentdb.com/api.php?amount=5'; 
$apiData = $api->request($url);

$_SESSION['api_data'] = $apiData;


$_SESSION['username'] = $username;
$_SESSION['age'] = $age;
$line = $username . ";" . $age . ";" . $theme . ";" . $prize . ";" . $difficulty . "\n";
file_put_contents("data.txt", $line, FILE_APPEND);

require 'db.php';
require 'Student.php';

$order = new Student($pdo);
$order->add($username, $age, $theme, $prize, $difficulty);

header("Location: index.php");
exit();
