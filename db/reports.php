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
    function reportVocab($start, $end, $pageStart, $rows_per_page)//reportVocab.php
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

    function reportEditDefinition($start, $end, $pageStart, $rows_per_page)//reportDefinition.php
    {
        try {
            $sql = "SELECT a.old_definition, a.old_example, a.new_definition, a.new_example, a.username, a.status, a.date, d.username AS verifyBy, b.vocabulary, c.pos_name2 FROM edit_definition a
            INNER JOIN vocabulary b ON a.v_id = b.v_id
            INNER JOIN parts_of_speech c ON a.pos_id = c.pos_id
            INNER JOIN expert_language d ON a.verifyBy = d.e_id
                WHERE a.date BETWEEN :start AND :end
                ORDER BY a.date ASC
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
    function reportEditVocab($start, $end, $pageStart, $rows_per_page)//reportEditVocab.php
    {
        try {
            $sql = "SELECT a.old_vocab, a.new_vocab, a.username, a.status, a.date, d.username AS verifyBy FROM edit_vocab a
            INNER JOIN expert_language d ON a.verifyBy = d.e_id
                WHERE a.date BETWEEN :start AND :end
                ORDER BY a.date ASC
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
    function reportMember($start, $end, $pageStart, $rows_per_page)//reportMember.php
    {
        try {
            $sql = "SELECT * FROM member
                WHERE date BETWEEN :start AND :end
                ORDER BY date ASC
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
    function reportEpl($start, $end, $pageStart, $rows_per_page) //reportEpl.php
    {
        try {
            $sql = "SELECT * FROM expert_language
                WHERE date BETWEEN :start AND :end AND status = 'approve'
                ORDER BY date ASC
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
    // Num row questions_page.php
    function vocabNumRows()//reportVocab.php
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
    function editVocabNumRows()//reportEditVocab.php
    {
        try {
            $sql = "SELECT COUNT(*)
                    FROM edit_vocab";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $rowCount = $stmt->fetchColumn();
            return $rowCount;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    function editDefinitionNumRows()//reportDefinition.php
    {
        try {
            $sql = "SELECT COUNT(*)
                    FROM edit_definition";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $rowCount = $stmt->fetchColumn();
            return $rowCount;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    function memberNumRows()//Num row questions_page.php
    {
        try {
            $sql = "SELECT COUNT(*) FROM member";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $rowCount = $stmt->fetchColumn();
            return $rowCount;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    function eplNumRows()//Num row questions_page.php
    {
        try {
            $sql = "SELECT COUNT(*) FROM expert_language";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $rowCount = $stmt->fetchColumn();
            return $rowCount;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
}