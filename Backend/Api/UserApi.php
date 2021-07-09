<?php

/**
 * ユーザーアプリケーションへのアクセスを提供するAPI。
 * CRUD操作に対応している。
 * レスポンスはJSON形式で返る。
 */

require_once(dirname(__FILE__) . '/../Application/UserApplication.php');

header("Content-Type: application/json; charset=utf-8");
$userApi = new UserApi();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['type'] === 'create') {
    // 作成の場合
    $errorCode = $userApi->createUser($_POST);
    echo json_encode(['errorCode' => $errorCode]);
} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // 参照の場合
    $user = $userApi->readUserFromId();
    echo json_encode($user);
} else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['type'] === 'update') {
    // 更新の場合
    $errorCode = $userApi->updateUser($_POST);
    echo json_encode(['errorCode' => $errorCode]);
} else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['type'] === 'delete') {
    // 削除の場合
    $errorCode = $userApi->deleteUser($_POST);
    echo json_encode(['errorCode' => $errorCode]);
}

class UserApi
{
    private UserApplication $userApplication; // ユーザーアプリケーション

    /**
     * ユーザーアプリケーションを用意する。
     */
    public function __construct()
    {
        $this->userApplication = new UserApplication();
    }

    /**
     * ユーザーの作成を行う。
     * @return エラーコード。
     */
    public function createUser($post)
    {
        return $this->userApplication->createUser($post);
    }

    /**
     * IDを元にユーザーを取得するメソッド。
     * IDはセッションから取得される。
     * ユーザーは1人のみ返される。
     * @return array ユーザー。
     */
    public function readUserFromId()
    {
        session_start();
        if (!array_key_exists('userId', $_SESSION)) {
            return [];
        }

        $userEntity = $this->userApplication->readUserFromId($_SESSION['userId']);
        $user['id'] = $userEntity->getId();
        $user['name'] = $userEntity->getName();
        $user['password'] = $userEntity->getPassword();
        $user['picture'] = $userEntity->getPicture();
        $user['birthday'] = $userEntity->getBirthday();
        $user['gender'] = $userEntity->getGender();
        $user['background'] = $userEntity->getBackground();
        $user['qualification'] = $userEntity->getQualification();
        $user['profile'] = $userEntity->getProfile();

        return $user;
    }

    /**
     * IDを元にユーザーを更新するメソッド。
     * @return エラーコード。
     */
    public function updateUser($post)
    {
        if (!array_key_exists('id', $post)) {
            return ['errorCode' => '99999'];
        }

        return $this->userApplication->updateUser($post);
    }

    /**
     * IDを元にユーザーを削除するメソッド。
     * @return エラーコード。
     */
    public function deleteUser($post)
    {
        if (!array_key_exists('id', $post)) {
            return ['errorCode' => '99999'];
        }

        return $this->userApplication->deleteUser($post);
    }
}
