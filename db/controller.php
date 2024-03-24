<?php
require_once "config.php";
class Controller{
    private $db;
    function __construct($con){
        $this->db=$con;
    }
    //Delete Function
    function cancelStatus($id){
        try{
            $sql = "DELETE FROM expert_language WHERE e_id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":id",$id);
            $stmt->execute();
            return true;

        }catch(PDOException $e){
            echo $e->getMessage();
            return false;
        }
    }

    //Update function
    function updateStatus($id, $status){
        try{
            $sql= "UPDATE expert_language
            SET status = :status
            WHERE e_id=:id";
            $stmt=$this->db->prepare($sql);
            $stmt->bindParam(":status", $status);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            return true;

        }catch(PDOException $e){
            echo $e->getMessage();
            return false;
        }
    }
}