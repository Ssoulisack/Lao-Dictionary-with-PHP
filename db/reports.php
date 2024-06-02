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
    function reportVocab($start, $end)
    {
        try {
            $sql = "SELECT a.vocabulary, a.character_id, c.pos_name2, b.definition, b.example, b.date 
                FROM definition b
                INNER JOIN vocabulary a ON b.v_id = a.v_id
                INNER JOIN parts_of_speech c ON b.pos_id = c.pos_id
                WHERE b.date BETWEEN :start AND :end
                ORDER BY a.character_id ASC";
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