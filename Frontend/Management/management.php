<?php

/**
 * ログインの成否を判断し、成功なら自己紹介画面、失敗ならログイン失敗画面を出力する。
 * ユーザーのログイン情報はPOSTから取得する。
 */

require_once(dirname(__FILE__) . '/../../Backend/Application/AdminApplication.php');

if (!array_key_exists('mail', $_POST)) {
    require_once('LoginFailed.html');
    exit;
}

$adminApplication = new AdminApplication();
$adminEntity = $adminApplication->readAdminFromMail($_POST['mail']);

if (!empty($adminEntity) && password_verify($_POST['password'], $adminEntity->getPassword())) {
    require_once(dirname(__FILE__) . '/../../Backend/Application/UserApplication.php');
    require_once(dirname(__FILE__) . '/../../Backend/Application/JobChangeApplication.php');
    require_once(dirname(__FILE__) . '/../../Backend/Application/CareerApplication.php');
    require_once(dirname(__FILE__) . '/../../Backend/Application/BookApplication.php');
} else {
    require_once('LoginFailed.html');
    exit;
}

?>

<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>管理画面</title>
    <link rel='stylesheet' href='Css/Main.css'>
    <link rel='stylesheet' href='Css/Menu.css'>
    <link rel='stylesheet' href='Css/Management.css'>
</head>

<body>
    <div id='root'>
        <img id='root-background' src='../../Picture/Study.jpg'></img>
        <div id='root-menu'>
            <div id='root-menu-user'>ユーザー</div>
            <div id='root-menu-job_change'>転職</div>
            <div id='root-menu-career'>経歴</div>
            <div id='root-menu-book'>書籍</div>
        </div>
        <div id='root-user'>
            <table id='root-user-table'>
                <tbody>
                    <tr>
                        <th id='root-user-table-header-create'>作成</th>
                        <th id='root-user-table-header-update'>更新</th>
                        <th id='root-user-table-header-delete'>削除</th>
                        <th id='root-user-table-header-id'>ID</th>
                        <th id='root-user-table-header-name'>氏名</th>
                        <th id='root-user-table-header-mail'>メールアドレス</th>
                        <th id='root-user-table-header-password'>パスワード</th>
                        <th id='root-user-table-header-picture'>写真</th>
                        <th id='root-user-table-header-birthday'>生年月日</th>
                        <th id='root-user-table-header-gender'>性別</th>
                        <th id='root-user-table-header-background'>学歴/職歴</th>
                        <th id='root-user-table-header-qualification'>資格</th>
                        <th id='root-user-table-header-profile'>自己PR</th>
                    </tr>
                    <?php
                    $userApplication = new UserApplication();
                    $userEntities = $userApplication->readAllUser();
                    $userIndex = 0;
                    foreach ($userEntities as $userEntity) {
                        echo "<tr>";
                        echo "<td></td>";
                        echo "<td id='root-user-table-update-$userIndex' class='root-user-table-update'>更新</td>";
                        echo "<td id='root-user-table-delete-$userIndex' class='root-user-table-delete'>削除</td>";
                        echo "<td id='root-user-table-id-$userIndex'>{$userEntity->getId()}</td>";
                        echo "<td id='root-user-table-name-$userIndex' contenteditable='true'>{$userEntity->getName()}</td>";
                        echo "<td id='root-user-table-mail-$userIndex' contenteditable='true'>{$userEntity->getMail()}</td>";
                        echo "<td id='root-user-table-password-$userIndex' contenteditable='true'>{$userEntity->getPassword()}</td>";
                        echo "<td id='root-user-table-picture-$userIndex' contenteditable='true'>{$userEntity->getPicture()}</td>";
                        echo "<td id='root-user-table-birthday-$userIndex' contenteditable='true'>{$userEntity->getBirthday()}</td>";
                        echo "<td id='root-user-table-gender-$userIndex' contenteditable='true'>{$userEntity->getGender()}</td>";
                        echo "<td id='root-user-table-background-$userIndex' contenteditable='true'>" . nl2br($userEntity->getBackground()) . "</td>";
                        echo "<td id='root-user-table-qualification-$userIndex' contenteditable='true'>" . nl2br($userEntity->getQualification()) . "</td>";
                        echo "<td id='root-user-table-profile-$userIndex' contenteditable='true'>" . nl2br($userEntity->getProfile()) . "</td>";
                        echo '</tr>';
                        $userIndex++;
                    }
                    ?>
                    <tr>
                        <td id='root-user-table-create'>作成</td>
                        <td></td>
                        <td></td>
                        <td id='root-user-table-create-id' contenteditable='true'></td>
                        <td id='root-user-table-create-name' contenteditable='true'></td>
                        <td id='root-user-table-create-mail' contenteditable='true'></td>
                        <td id='root-user-table-create-password' contenteditable='true'></td>
                        <td id='root-user-table-create-picture' contenteditable='true'></td>
                        <td id='root-user-table-create-birthday' contenteditable='true'></td>
                        <td id='root-user-table-create-gender' contenteditable='true'></td>
                        <td id='root-user-table-create-background' contenteditable='true'></td>
                        <td id='root-user-table-create-qualification' contenteditable='true'></td>
                        <td id='root-user-table-create-profile' contenteditable='true'></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div id='root-job_change'>
            <table id='root-job_change-table'>
                <tbody>
                    <tr>
                        <th>作成</th>
                        <th>更新</th>
                        <th>削除</th>
                        <th>ID</th>
                        <th>ユーザーID</th>
                        <th>転職理由</th>
                        <th>志望動機</th>
                        <th>活かせる経験</th>
                    </tr>
                    <?php
                    $jobChangeApplication = new JobChangeApplication();
                    $jobChangeEntities = $jobChangeApplication->readAllJobChange();
                    $jobChangeIndex = 0;
                    foreach ($jobChangeEntities as $jobChangeEntity) {
                        echo "<tr>";
                        echo "<td></td>";
                        echo "<td id='root-job_change-table-update-$jobChangeIndex' class='root-job_change-table-update'>更新</td>";
                        echo "<td id='root-job_change-table-delete-$jobChangeIndex' class='root-job_change-table-delete'>削除</td>";
                        echo "<td id='root-job_change-table-id-$jobChangeIndex'>" . nl2br($jobChangeEntity->getId()) . "</td>";
                        echo "<td id='root-job_change-table-user_id-$jobChangeIndex' contenteditable='true'>" . nl2br($jobChangeEntity->getUserId()) . "</td>";
                        echo "<td id='root-job_change-table-reason-$jobChangeIndex' contenteditable='true'>" . nl2br($jobChangeEntity->getReason()) . "</td>";
                        echo "<td id='root-job_change-table-motivation-$jobChangeIndex' contenteditable='true'>" . nl2br($jobChangeEntity->getMotivation()) . "</td>";
                        echo "<td id='root-job_change-table-experience-$jobChangeIndex' contenteditable='true'>" . nl2br($jobChangeEntity->getExperience()) . "</td>";
                        echo '</tr>';
                        $jobChangeIndex++;
                    }
                    ?>
                    <tr>
                        <td id='root-job_change-table-create'>作成</td>
                        <td></td>
                        <td></td>
                        <td id='root-job_change-table-create-id' contenteditable='true'></td>
                        <td id='root-job_change-table-create-user_id' contenteditable='true'></td>
                        <td id='root-job_change-table-create-reason' contenteditable='true'></td>
                        <td id='root-job_change-table-create-motivation' contenteditable='true'></td>
                        <td id='root-job_change-table-create-experience' contenteditable='true'></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div id='root-career'>
            <table id='root-career-table'>
                <tbody>
                    <tr>
                        <th>作成</th>
                        <th>更新</th>
                        <th>削除</th>
                        <th>ID</th>
                        <th>ユーザーID</th>
                        <th>開始日</th>
                        <th>終了日</th>
                        <th>概要</th>
                        <th>説明文</th>
                    </tr>
                    <?php
                    $careerApplication = new CareerApplication();
                    $careerEntities = $careerApplication->readAllCareer();
                    $careerIndex = 0;
                    foreach ($careerEntities as $careerEntity) {
                        echo "<tr>";
                        echo "<td></td>";
                        echo "<td id='root-career-table-update-$careerIndex' class='root-career-table-update'>更新</td>";
                        echo "<td id='root-career-table-delete-$careerIndex' class='root-career-table-delete'>削除</td>";
                        echo "<td id='root-career-table-id-$careerIndex'>{$careerEntity->getId()}</td>";
                        echo "<td id='root-career-table-user_id-$careerIndex' contenteditable='true'>{$careerEntity->getUserId()}</td>";
                        echo "<td id='root-career-table-start-$careerIndex' contenteditable='true'>{$careerEntity->getStartDate()}</td>";
                        echo "<td id='root-career-table-finish-$careerIndex' contenteditable='true'>{$careerEntity->getFinishDate()}</td>";
                        echo "<td id='root-career-table-overview-$careerIndex' contenteditable='true'>{$careerEntity->getOverview()}</td>";
                        echo "<td id='root-career-table-explain-$careerIndex' contenteditable='true'>" . nl2br($careerEntity->getExplainText()) . "</td>";
                        echo '</tr>';
                        $careerIndex++;
                    }
                    ?>
                    <tr>
                        <td id='root-career-table-create'>作成</td>
                        <td></td>
                        <td></td>
                        <td id='root-career-table-create-id' contenteditable='true'></td>
                        <td id='root-career-table-create-user_id' contenteditable='true'></td>
                        <td id='root-career-table-create-start' contenteditable='true'></td>
                        <td id='root-career-table-create-finish' contenteditable='true'></td>
                        <td id='root-career-table-create-overview' contenteditable='true'></td>
                        <td id='root-career-table-create-explain' contenteditable='true'></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div id='root-book'>
            <table id='root-book-table'>
                <tbody>
                    <tr>
                        <th>作成</th>
                        <th>更新</th>
                        <th>削除</th>
                        <th>ID</th>
                        <th>ユーザーID</th>
                        <th>タイトル</th>
                        <th>説明文</th>
                        <th>写真</th>
                    </tr>
                    <?php
                    $bookApplication = new BookApplication();
                    $bookEntities = $bookApplication->readAllBook();
                    $bookIndex = 0;
                    foreach ($bookEntities as $bookEntity) {
                        echo "<tr>";
                        echo "<td></td>";
                        echo "<td id='root-book-table-update-$bookIndex' class='root-book-table-update'>更新</td>";
                        echo "<td id='root-book-table-delete-$bookIndex' class='root-book-table-delete'>削除</td>";
                        echo "<td id='root-book-table-id-$bookIndex'>{$bookEntity->getId()}</td>";
                        echo "<td id='root-book-table-user_id-$bookIndex' contenteditable='true'>{$bookEntity->getUserId()}</td>";
                        echo "<td id='root-book-table-title-$bookIndex' contenteditable='true'>{$bookEntity->getTitle()}</td>";
                        echo "<td id='root-book-table-explain-$bookIndex' contenteditable='true'>" . nl2br($bookEntity->getExplainText()) . "</td>";
                        echo "<td id='root-book-table-picture-$bookIndex' contenteditable='true'>{$bookEntity->getPicture()}</td>";
                        echo '</tr>';
                        $bookIndex++;
                    }
                    ?>
                    <tr>
                        <td id='root-book-table-create'>作成</td>
                        <td></td>
                        <td></td>
                        <td id='root-book-table-create-id' contenteditable='true'></td>
                        <td id='root-book-table-create-user_id' contenteditable='true'></td>
                        <td id='root-book-table-create-title' contenteditable='true'></td>
                        <td id='root-book-table-create-explain' contenteditable='true'></td>
                        <td id='root-book-table-create-picture' contenteditable='true'></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <script src='../Library/Utility.js'></script>
    <script src='./Js/Menu.js'></script>
    <script src='../Library/User.js'></script>
    <script src='./Js/User.js'></script>
    <script src='../Library/JobChange.js'></script>
    <script src='./Js/JobChange.js'></script>
    <script src='../Library/Career.js'></script>
    <script src='./Js/Career.js'></script>
    <script src='../Library/Book.js'></script>
    <script src='./Js/Book.js'></script>
</body>

</html>