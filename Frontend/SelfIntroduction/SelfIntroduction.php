<?php

require_once('../../Backend/Application/UserApplication.php');

if (!array_key_exists('mail', $_POST)) {
    require_once('LoginFailed.html');
    exit;
}

$userApplication = new UserApplication();
$userEntity = $userApplication->readUserFromMail($_POST['mail']);

if (!empty($userEntity) && password_verify($_POST['password'], $userEntity->getPassword())) {
    session_start();
    $_SESSION['userId'] = $userEntity->getId();
} else {
    require_once('LoginFailed.html');
    exit;
}

?>

<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>自己紹介</title>
    <link rel='stylesheet' href='Css/Main.css'>
    <link rel='stylesheet' href='Css/Menu.css'>
    <link rel='stylesheet' href='Css/User.css'>
    <link rel='stylesheet' href='Css/JobChange.css'>
    <link rel='stylesheet' href='Css/Career.css'>
    <link rel='stylesheet' href='Css/Book.css'>
</head>

<body>
    <div id='root'>
        <img id='root-background' src='../../Picture/Study.jpg'></img>
    </div>

    <script src='../Library/User.js'></script>
    <script src='./Js/User.js'></script>
    <script src='../Library/JobChange.js'></script>
    <script src='./Js/JobChange.js'></script>
    <script src='../Library/Career.js'></script>
    <script src='./Js/Career.js'></script>
    <script src='../Library/Book.js'></script>
    <script src='./Js/Book.js'></script>
    <script src='./Js/Menu.js'></script>
</body>

</html>