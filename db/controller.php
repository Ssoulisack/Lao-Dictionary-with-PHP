<?php
require_once "config.php";
// session_start();
class Controller
{
    private $db;
    function __construct($con)
    {
        $this->db = $con;
    }
    //Show info Characters & Part of speech
    function infoCharacter(){
        try{
            $sql = "SELECT * FROM Characters";
            $stmt = $this->db->query($sql);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }catch(Exception $e){
            return $e->getMessage();
        }
    }
        function infoPos()
        {
            try {
                $sql = "SELECT * FROM parts_of_speech";
                $result = $this->db->query($sql);
                return $result;
            } catch (PDOException $e) {
                echo $e->getMessage();
                return false;
            }
        }

    //**********GET ALL VOCAB ***********/
    function getAllVocab(){
        try{
            $sql = "SELECT * FROM vocabulary";
            $result = $this->db->query($sql);
            return $result;
        }catch(PDOException $e) {
            return $e->getMessage();
        }
    }

    //********CANCEL USER EXPERT LANGUAGE*****
    function cancelStatus($id)
    {
        try {
            $sql = "DELETE FROM expert_language WHERE e_id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            return true;

        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    //Update function ********CANCEL USER EXPERT LANGUAGE*******
    function updateStatus($id, $status)
    {
        try {
            $sql = "UPDATE expert_language
            SET status = :status
            WHERE e_id=:id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":status", $status);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            return true;

        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    function selectVocab(){
        try {
            $sql = "SELECT * FROM vocabulary";
            $stmt = $this->db->query($sql);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;   
        }
    }
    
    // info Users
    // function infoAdmin(){
    //     try {
    //         $sql = "SELECT * FROM admin";
    //         $result = $this->db->query($sql);
    //         return $result;
            
    //     }catch(PDOException $e) {
    //         return false;
    //     }
    // }
    // function infoMembers(){
    //     try {
            
    //         $sql = "SELECT * FROM members";
    //         $result = $this->db->query($sql);
    //         return $result;
            
    //     }catch(PDOException $e) {
    //         return false;
    //     }
    // }
    // function infoEpl(){
    //     try {
            
    //         $sql = "SELECT * FROM expert_language";
    //         $result = $this->db->query($sql);
    //         return $result;
            
    //     }catch(PDOException $e) {
    //         return false;
    //     }
    // }

    function insert($user_id, $vocabulary, $character_id, $pos_id, $definition, $example) //Insert Vocab
    {
        try {
            if($_SESSION['urole'] == 'admin'){
                $sql1 = "INSERT INTO vocabulary (vocabulary, character_id, admin_id) VALUES (:vocabulary, :character_id, :admin_id)";
                $stmt = $this->db->prepare($sql1);
                $stmt->bindParam(":vocabulary", $vocabulary);
                $stmt->bindParam(":character_id", $character_id);
                $stmt->bindParam(":admin_id", $user_id);
                $stmt->execute();
                $lastID = $this->db->lastInsertId();
                
                $sql2 = "INSERT INTO definition (pos_id, definition, example, v_id, admin_id) VALUES (:pos_id, :definition, :example, :v_id, :admin_id)";
                $stmt2 = $this->db->prepare($sql2);
                $stmt2->bindParam(":pos_id", $pos_id);
                $stmt2->bindParam(":definition", $definition);
                $stmt2->bindParam(":example", $example);
                $stmt2->bindParam(":v_id", $lastID);
                $stmt2->bindParam(":admin_id", $user_id);
                $stmt2->execute();
                $this->db = null;
                return true;
            } else{
                $sql1 = "INSERT INTO vocabulary (vocabulary, e_id) VALUES (:vocabulary, :e_id)";
                $stmt = $this->db->prepare($sql1);
                $stmt->bindParam(":vocabulary", $vocabulary);
                $stmt->bindParam(":character_id", $character_id);
                $stmt->bindParam(":e_id", $user_id);
                $stmt->execute();
                $lastID = $this->db->lastInsertId();
                
                $sql2 = "INSERT INTO definition (pos_id, definition, example, v_id, e_id) VALUES (:pos_id, :definition, :example, :v_id, :e_id)";
                $stmt2 = $this->db->prepare($sql2);
                $stmt2->bindParam(":pos_id", $pos_id);
                $stmt2->bindParam(":definition", $definition);
                $stmt2->bindParam(":example", $example);
                $stmt2->bindParam(":v_id", $lastID);
                $stmt2->bindParam(":e_id", $user_id);
                $stmt2->execute();
                $this->db = null;
                return true;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    // ***********SEARCH VOCAB*******************
    function getVocabInfo($vocabulary){
        try{
            $vocab = '%'. $vocabulary .'%';
            $sql = "SELECT b.v_id, b.vocabulary, a.definition, a.example, c.pos_name2 FROM definition a 
            INNER JOIN vocabulary b ON b.v_id = a.v_id 
            INNER JOIN parts_of_speech c ON a.pos_id = c.pos_id
            WHERE vocabulary LIKE :vocab";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":vocab", $vocab);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
            
        }catch(PDOException $e) {
            return $e->getMessage();
        }
    }
    
    function showVocab($character_id){
        try{
            $sql = "SELECT 
            b.v_id, 
            b.vocabulary, 
            d.characters, 
            a.definition, 
            a.example, 
            c.pos_name2 
            FROM definition a 
            INNER JOIN vocabulary b ON b.v_id = a.v_id 
            INNER JOIN parts_of_speech c ON a.pos_id = c.pos_id 
            INNER JOIN characters d ON b.character_id = d.character_id 
            WHERE b.character_id = :character_id;";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":character_id", $character_id);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }catch(PDOException $e){
            return false;
        }
    }

    function showDetail($vocab_id){
        try{
            $sql = "SELECT 
            b.v_id, 
            b.vocabulary, 
            d.characters, 
            a.definition, 
            a.example, 
            c.pos_name2 
            FROM definition a 
            INNER JOIN vocabulary b ON b.v_id = a.v_id 
            INNER JOIN parts_of_speech c ON a.pos_id = c.pos_id 
            INNER JOIN characters d ON b.character_id = d.character_id 
            WHERE b.v_id = :v_id;";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":v_id", $vocab_id);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }catch(PDOException $e){
            return false;
        }
    }
    
}