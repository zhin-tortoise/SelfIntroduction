<?php

/**
 * 経歴アプリケーションへのアクセスを提供するAPI。
 * CRUD操作に対応している。
 * レスポンスはJSON形式で返る。
 */

require_once(dirname(__FILE__) . '/../Application/CareerApplication.php');

header("Content-Type: application/json; charset=utf-8");
$careerApi = new CareerApi();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['type'] === 'create') {
    // 作成の場合
    $errorCode = $careerApi->createCareer($_POST);
    echo json_encode(['errorCode' => $errorCode]);
} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // 参照の場合
    $career = $careerApi->readCareerFromUserId();
    echo json_encode($career);
} else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['type'] === 'update') {
    // 更新の場合
    $errorCode = $careerApi->updateCareer($_POST);
    echo json_encode(['errorCode' => $errorCode]);
} else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['type'] === 'delete') {
    // 削除の場合
    $errorCode = $careerApi->deleteCareer($_POST);
    echo json_encode(['errorCode' => $errorCode]);
}

class CareerApi
{
    private $careerApplication; // 経歴アプリケーション

    /**
     * 経歴アプリケーションを用意する。
     */
    public function __construct()
    {
        $this->careerApplication = new CareerApplication();
    }

    /**
     * 経歴の作成を行う。
     * @return エラーコード。
     */
    public function createCareer($post)
    {
        return $this->careerApplication->createCareer($post);
    }

    /**
     * ユーザーIDを元に経歴を取得するメソッド。
     * ユーザーIDはセッションから取得される。
     */
    public function readCareerFromUserId()
    {
        session_start();
        if (!array_key_exists('userId', $_SESSION)) {
            return [];
        }

        $careerEntities = $this->careerApplication->readCareerFromUserId($_SESSION['userId']);
        $careers = [];
        foreach ($careerEntities as $careerEntity) {
            $career['id'] = $careerEntity->getId();
            $career['startDate'] = $careerEntity->getStartDate();
            $career['finishDate'] = $careerEntity->getFinishDate();
            $career['overview'] = $careerEntity->getOverview();
            $career['explainText'] = $careerEntity->getExplainText();

            $careers[] = $career;
        }

        return $careers;
    }

    /**
     * IDを元に経歴を更新するメソッド。
     * @return エラーコード。
     */
    public function updateCareer($post)
    {
        if (!array_key_exists('id', $post)) {
            return ['errorCode' => '99999'];
        }

        return $this->careerApplication->updateCareer($post);
    }

    /**
     * IDを元に経歴を削除するメソッド。
     * @return エラーコード。
     */
    public function deleteCareer($post)
    {
        if (!array_key_exists('id', $post)) {
            return ['errorCode' => '99999'];
        }

        return $this->careerApplication->deleteCareer($post);
    }
}
