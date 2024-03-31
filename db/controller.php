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
    //Delete Function ********CANCEL USER EXPERT LANGUAGE*****
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

    // SELECT Function
    function selectPos()
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
    
    //info Users
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

    //INSERT Function
    function insert($vocabulary, $pos_id ,$user_id)
    {
        try {
            if($_SESSION['urole'] == 'admin'){
                $sql = "INSERT INTO vocabulary (vocabulary, pos_id, admin_id) VALUES (:vocabulary, :pos_id, :admin_id)";
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(":vocabulary", $vocabulary);
                $stmt->bindParam(":pos_id", $pos_id);
                $stmt->bindParam(":admin_id", $user_id);
                $stmt->execute();
                return true;
            } else {
                $sql = "INSERT INTO vocabulary (vocabulary, pos_id, e_id) VALUES (:vocabulary, pos_id, :e_id";
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(":vocabulary", $vocabulary);
                $stmt->bindParam(":pos_id", $pos_id);
                $stmt->bindParam(":e_id", $user_id);
                $stmt->execute();
                return true;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    function insertDefinition($definition, $example, $v_id, $e_id, $admin_id){
        $sql = "INSERT INTO definition (definition, example, v_id, e_id, admin_id) VALUES (:definition, :example, (SELECT id FROM vocabulary WHERE v_id = :v_id ))";

    }
}