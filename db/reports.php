<?php
require_once "config.php";

class Report
{
    private $db;
    function __construct($con)
    {
        $this->db = $con;
    }
    // report_vocab.php (Get vocab info)
    function reportVocab($start, $end, $pageStart, $rows_per_page)
    {
        try {
            $sql = "SELECT a.vocabulary, a.character_id, c.pos_name2, b.definition, b.example, b.date 
                FROM definition b
                INNER JOIN vocabulary a ON b.v_id = a.v_id
                INNER JOIN parts_of_speech c ON b.pos_id = c.pos_id
                WHERE b.date BETWEEN :start AND :end
                ORDER BY b.date ASC
                LIMIT :pageStart, :rows_per_page";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":start", $start);
            $stmt->bindParam(":end", $end);
            $stmt->bindParam(":pageStart", $pageStart, PDO::PARAM_INT);
            $stmt->bindParam(":rows_per_page", $rows_per_page, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    function vocabNumRows()//Num row questions_page.php
    {
        try {
            $sql = "SELECT COUNT(*)
            FROM definition b
                INNER JOIN vocabulary a ON b.v_id = a.v_id
                INNER JOIN parts_of_speech c ON b.pos_id = c.pos_id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $rowCount = $stmt->fetchColumn();
            return $rowCount;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    function reportMember($start, $end)
    {
        try {
            $sql = "SELECT * FROM member
                WHERE date BETWEEN :start AND :end
                ORDER BY date ASC";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":start", $start);
            $stmt->bindParam(":end", $end);
            return $stmt;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    function reportEpl($start, $end, $pageStart, $rows_per_page)
    {
        try {
            $sql = "SELECT * FROM expert_language
                WHERE date BETWEEN :start AND :end AND status = 'approve'
                ORDER BY date ASC";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":start", $start);
            $stmt->bindParam(":end", $end);
            return $stmt;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

}