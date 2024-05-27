<?php
require_once "config.php";

class Question
{
    private $db;
    function __construct($con)
    {
        $this->db = $con;
    }
    function addQuestion($title, $content, $user_id)
    {//addQuestion.php
        try {
            $sql = "INSERT INTO question (title, content, user_id) VALUES (:title, :content, :user_id)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":title", $title);
            $stmt->bindParam(":content", $content);
            $stmt->bindParam(":user_id", $user_id);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    function showQuestions($start, $rows_per_page)
    {//pagination questions_page.php
        try {
            $sql = "SELECT * FROM question LIMIT $start, $rows_per_page";
            $stmt = $this->db->query($sql);
            return $stmt;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    function questionNumRows()//Num row questions_page.php
    {
        try {
            $sql = "SELECT COUNT(*) FROM question";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $rowCount = $stmt->fetchColumn();
            return $rowCount;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    function questionDetail($q_id)//question_detail.php
    {
        try {
            $sql = "SELECT a.q_id, a.title, a.content, a.create_at, a.user_id, b.username
            FROM question a
            INNER JOIN member b ON b.m_id = a.user_id
            WHERE a.q_id = :q_id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam("q_id", $q_id);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    function deletePost($id) //question_detail.php
    {
        try {
            $sql = "DELETE FROM question WHERE q_id = :q_id ";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":q_id", $id);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    function addComment($q_id, $user_id, $username, $content) //question_detail.php (comment) 
    {
        try {
                $sql = "INSERT INTO comment (q_id, content, user_id, username) VALUES (:q_id, :content, :user_id, :username)";
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(":q_id", $q_id);
                $stmt->bindParam(":content", $content);
                $stmt->bindParam(":user_id", $user_id);
                $stmt->bindParam(":username", $username);
                $stmt->execute();
                return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    function showComment($q_id) //question_detail.php
    {
        try {
            $r_id = 0;
            $sql = "SELECT q_id, c_id, content, user_id, username, create_at
            FROM comment
            WHERE q_id = :q_id AND r_id = :r_id ORDER BY create_at DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":q_id", $q_id);
            $stmt->bindParam(":r_id", $r_id);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    function commentNumRows($q_id)//Num row question_detail.php
    {
        try {
            $sql = "SELECT COUNT(*) FROM comment WHERE q_id = :q_id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":q_id", $q_id);
            $stmt->execute();
            $rowCount = $stmt->fetchColumn();
            return $rowCount;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    function editComment($c_id, $content, $time)//edit_comment.php
    {
        try {
            $sql = "UPDATE comment SET content = :content, create_at = :timeCurrent WHERE c_id = :c_id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":content", $content);
            $stmt->bindParam(":timeCurrent", $time);
            $stmt->bindParam(":c_id", $c_id);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    function deleteComment($c_id)//deleteComment.php
    {
        try {
            $sql = "DELETE FROM comment WHERE c_id = :c_id ";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":c_id", $c_id);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    function reply($c_id, $q_id, $user_id, $username, $content) //reply.php (reply comment) 
    {
        try {
                $sql = "INSERT INTO comment (q_id, r_id, content, user_id, username) VALUES (:q_id, :r_id, :content, :user_id, :username)";
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(":q_id", $q_id);
                $stmt->bindParam(":r_id", $c_id);
                $stmt->bindParam(":content", $content);
                $stmt->bindParam(":user_id", $user_id);
                $stmt->bindParam(":username", $username);
                $stmt->execute();
                return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

}