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
    <title>読んだ書籍紹介</title>
    <link rel='stylesheet' href='Css/Main.css'>
    <link rel='stylesheet' href='Css/BookList.css'>
</head>

<body>
    <div id='root'>
        <img id='root-background' src='../../Picture/Study.jpg'></img>
        <ul id='root-book'>
            <?php
            require_once('../../Backend/Application/BookApplication.php');

            $bookApplication = new BookApplication();
            $bookEntities = $bookApplication->readBookFromUserId($_SESSION['userId']);
            $bookEntityIndex = 0;
            foreach ($bookEntities as $bookEntity) {
                echo "<li class='root-book-row'>";
                echo "<img id='root-book-row-picture-{$bookEntityIndex}' class='root-book-row-picture' src='{$bookEntity->getPicture()}'>";
                echo "<p id='root-book-row-title-{$bookEntityIndex}' class='root-book-row-title'>{$bookEntity->getTitle()}</p>";
                echo "<p id='root-book-row-explain-{$bookEntityIndex}' class='root-book-row-explain'>{$bookEntity->getExplainText()}</p>";
                echo '</li>';
                $bookEntityIndex++;
            }
            ?>
        </ul>
    </div>

    <script src='./Js/BookList.js'></script>
</body>

</html>