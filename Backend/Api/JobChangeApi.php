<?php

/**
 * 転職事由アプリケーションへのアクセスを提供するAPI。
 * CRUD操作に対応している。
 * レスポンスはJSON形式で返る。
 */

require_once(dirname(__FILE__) . '/../Application/JobChangeApplication.php');

header("Content-Type: application/json; charset=utf-8");
$jobChangeApi = new jobChangeApi();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['type'] === 'create') {
    // 作成の場合
    $errorCode = $jobChangeApi->createJobChange($_POST);
    echo json_encode(['errorCode' => $errorCode]);
} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // 参照の場合
    $jobChange = $jobChangeApi->readJobChangeFromUserId();
    echo json_encode($jobChange);
} else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['type'] === 'update') {
    // 更新の場合
    $errorCode = $jobChangeApi->updateJobChange($_POST);
    echo json_encode(['errorCode' => $errorCode]);
} else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['type'] === 'delete') {
    // 削除の場合
    $errorCode = $jobChangeApi->deleteJobChange($_POST);
    echo json_encode(['errorCode' => $errorCode]);
}

class JobChangeApi
{
    private JobChangeApplication $jobChangeApplication; // 転職事由アプリケーション

    /**
     * 転職事由アプリケーションを用意する。
     */
    public function __construct()
    {
        $this->jobChangeApplication = new JobChangeApplication();
    }

    /**
     * 転職事由の作成を行う。
     * @return エラーコード。
     */
    public function createJobChange($post)
    {
        return $this->jobChangeApplication->createJobChange($post);
    }

    /**
     * ユーザーIDを元に転職を取得するメソッド。
     * ユーザーIDはセッションから取得される。
     */
    public function readJobChangeFromUserId()
    {
        session_start();
        if (!array_key_exists('userId', $_SESSION)) {
            return [];
        }

        $jobChangeEntity = $this->jobChangeApplication->readJobChangeFromUserId($_SESSION['userId']);
        $jobChange['id'] = $jobChangeEntity->getId();
        $jobChange['userId'] = $jobChangeEntity->getUserId();
        $jobChange['reason'] = $jobChangeEntity->getReason();
        $jobChange['motivation'] = $jobChangeEntity->getMotivation();
        $jobChange['experience'] = $jobChangeEntity->getExperience();

        return $jobChange;
    }

    /**
     * IDを元に転職を更新するメソッド。
     * @return エラーコード。
     */
    public function updateJobChange($post)
    {
        if (!array_key_exists('id', $post)) {
            return ['errorCode' => '99999'];
        }

        return $this->jobChangeApplication->updateJobChange($post);
    }

    /**
     * IDを元に転職を削除するメソッド。
     * @return エラーコード。
     */
    public function deleteJobChange($post)
    {
        if (!array_key_exists('id', $post)) {
            return ['errorCode' => '99999'];
        }

        return $this->jobChangeApplication->deleteJobChange($post);
    }
}
