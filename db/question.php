<?php
require_once "config.php";

class Question{
    private $db;
    function __construct($con){
        $this->db = $con;
    }
    function addQuestion($title, $content, $user_id){
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
    
    function showQuestions($start, $rows_per_page){
        try{
            $sql = "SELECT * FROM question LIMIT $start, $rows_per_page";
            $stmt = $this->db->query($sql);
            return $stmt;
        }catch(PDOException $e){
            echo $e->getMessage();
            return false;
        }
    }
    function questionNumRows(){
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
}