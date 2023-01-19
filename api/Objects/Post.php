<?php

use config\Db;

class Post
{
    public static function actionGetTotalPost(): void
    {
        $db = new Db;
        $db = $db->getConnection();

        $sql = $db->prepare("SELECT * FROM `blog`");
        $sql->execute();
        $blogList = $sql->fetchAll(PDO::FETCH_ASSOC);

        if(!$blogList)
        {
            http_response_code(404);
            echo json_encode(array(
                "status" => false,
                "message" => "Посты не были найдены."
            ), JSON_UNESCAPED_UNICODE);
        } else {
            http_response_code(200);
            echo json_encode($blogList, JSON_PRETTY_PRINT);
        }
    }
    public static function actionGetPostById($id): void
    {
        $db = new Db;
        $db = $db->getConnection();

        $sql = $db->prepare("SELECT * FROM `blog` WHERE ID = {$id}");
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        if($result)
        {
            http_response_code(200);
            echo json_encode($result, JSON_PRETTY_PRINT);
        } else {
            http_response_code(404);
            echo json_encode(array(
                "status" => false,
                "message" => "Пост не найден."
            ), JSON_UNESCAPED_UNICODE);
        }
    }
    public static function actionDeletePostById($id): void
    {
        $db = new Db;
        $db = $db->getConnection();

        $result = $db->exec("DELETE FROM `blog` WHERE `ID` = {$id}");
        if($result)
        {
            http_response_code(200);
            echo json_encode(array(
                "status" => true,
                "message" => "Пост был удален."
            ), JSON_UNESCAPED_UNICODE);
        } else {
            http_response_code(404);
            echo json_encode(array(
                "status" => false,
                "message" => "Пост не найден."
            ), JSON_UNESCAPED_UNICODE);
        }
    }
    public static function actionUpdatePostById($id): void
    {
        $db = new Db;
        $db = $db->getConnection();

        $data = json_decode(file_get_contents('php://input'));
        $sql = "UPDATE blog SET ";
        foreach($data as $key=>$value) {
            if(is_numeric($value))
                $sql .= $key . " = " . $value . ", ";
            else
                $sql .= $key . " = " . "'" . $value . "'" . ", ";
        }

        $sql = trim($sql, ' '); // first trim last space
        $sql = trim($sql, ','); // then trim trailing and prefixing commas

        $sql .= " WHERE ID = {$id}";
        $result = $db->exec($sql);
        if($result)
        {
            http_response_code(200);
            echo json_encode(array(
                "status" => true,
                "message" => "Пост был изменен."
            ), JSON_UNESCAPED_UNICODE);
        } else {
            http_response_code(404);
            echo json_encode(array(
                "status" => false,
                "message" => "Пост не найден."
            ), JSON_UNESCAPED_UNICODE);
        }
    }
}