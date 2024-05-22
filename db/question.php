<?php
require_once "config.php";

class Question{
    private $db;
    function __construct($con){
        $this->db = $con;
    }
    function addQuestion($title, $content, $user_id){//addQuestion.php
        try{
            $sql = "INSERT INTO question (title, content, user_id) VALUES (:title, :content, :user_id)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":title", $title);
            $stmt->bindParam(":content", $content);
            $stmt->bindParam(":user_id", $user_id);
            $stmt->execute();
            return true;
        }catch(PDOException $e){
            echo $e->getMessage();
            return false;
        }
    }
    
    function showQuestions($start, $rows_per_page){//pagination questions_page.php
        try{
            $sql = "SELECT * FROM question LIMIT $start, $rows_per_page";
            $stmt = $this->db->query($sql);
            return $stmt;
        }catch(PDOException $e){
            echo $e->getMessage();
            return false;
        }
    }
    function questionNumRows(){//Num row questions_page.php
        try{
            $sql = "SELECT COUNT(*) FROM question";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $rowCount = $stmt->fetchColumn();
            return $rowCount;
        }catch(PDOException $e){
            echo $e->getMessage();
            return false;
        }
    }
    function questionDetail($id){//question_detail.php
        try{
            $sql = "SELECT a.q_id, a.title, a.content, a.create_at, b.username
            FROM question a
            INNER JOIN member b ON b.m_id = a.user_id
            WHERE a.q_id = :q_id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam("q_id", $id);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        }catch(PDOException $e){
           echo $e->getMessage();
            return false;
        }
    }
}