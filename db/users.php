<?php
require_once "config.php";
// session_start();
class Users
{
    private $db;
    function __construct($con)
    {
        $this->db = $con;
    }
    //insert admin
    function insertAdmin($username, $email, $password, $fname, $lname, $address, $tel, $urole)
    {
        try {
            $passwordHash = md5($password.$username);
            $sql = "INSERT INTO admin(username, firstname, lastname, email, password, address, telephone, urole) VALUES (:username, :fname, :lname, :email, :password, :address, :tel, :urole)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":fname", $fname);
            $stmt->bindParam(":lname", $lname);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":password", $passwordHash);
            $stmt->bindParam(":address", $address);
            $stmt->bindParam(":tel", $tel);
            $stmt->bindParam(":urole", $urole);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }

    }
    // Insert member 
    function insertUser($username, $email, $password, $fname, $lname, $address, $tel, $urole)
    {
        try {
            $passwordHash = md5($password.$username);
            $sql = "INSERT INTO member(username, firstname, lastname, email, password, address, telephone, urole) VALUES (:username, :fname, :lname, :email, :password, :address, :tel, :urole)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":fname", $fname);
            $stmt->bindParam(":lname", $lname);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":password", $passwordHash);
            $stmt->bindParam(":address", $address);
            $stmt->bindParam(":tel", $tel);
            $stmt->bindParam(":urole", $urole);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }

    }

    //check user & email in database
    function checkUserData($username, $email)
    {
        try {
            $sql = "SELECT COUNT(*) as num 
            FROM (
                SELECT username, email FROM member WHERE username = :username OR email = :email
                UNION ALL
                SELECT username, email FROM admin WHERE username = :username OR email = :email
                UNION ALL
                SELECT username, email FROM expert_language WHERE username = :username OR email = :email
            ) AS combined_results";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":email", $email);
            $stmt->execute();
            $result = $stmt->fetch();
            return $result;

        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }


    //insert Language Expert
    function insertLanguageExpert($username, $email, $password, $fname, $lname, $address, $tel, $urole, $status, $doc)
    {
        try {
            $imageContent = file_get_contents($doc);
            $passwordHash = md5($password.$username);
            $sql = "INSERT INTO expert_language (username, firstname, lastname, email, password, address, telephone, credentials, status, urole) VALUES (:username, :fname, :lname, :email, :password, :address, :tel, :document, :status, :urole)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":fname", $fname);
            $stmt->bindParam(":lname", $lname);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":password", $passwordHash);
            $stmt->bindParam(":address", $address);
            $stmt->bindParam(":tel", $tel);
            $stmt->bindParam(":document", $imageContent);
            $stmt->bindParam(":status", $status);
            $stmt->bindParam(":urole", $urole);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    //Function login by admin
    function loginAdmin($username, $password){
        try{
            $sql= "SELECT * FROM admin WHERE username=:username AND password=:password";
            $stmt= $this->db->prepare($sql);
            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":password", $password);
            $stmt->execute();
            $result= $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
            
        }catch(PDOException $e){
            echo $e->getMessage();
            return false;
        }
    }

    //Function Login by ExpertLanguage
    function loginExpertLanguage($username,$password){
        try{
            $sql= "SELECT * FROM expert_language WHERE username=:username AND password=:password";
            $stmt= $this->db->prepare($sql);
            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":password", $password);
            $stmt->execute();
            $result= $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
            
        }catch(PDOException $e){
            echo $e->getMessage();
            return false;
        }
    }

    //Function Login by member
    function loginMembers($username,$password){
        try{
            $sql= "SELECT * FROM member WHERE username=:username AND password=:password";
            $stmt= $this->db->prepare($sql);
            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":password", $password);
            $stmt->execute();
            $result= $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
            
        }catch(PDOException $e){
            echo $e->getMessage();
            return false;
        }
    }
    //Approve Expert Language
    function eplRequest($status) {
        try{
            $sql = "SELECT * FROM expert_language WHERE status = :status";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":status", $status);
            $stmt->execute();
            return $stmt;
        }catch(PDOException $e){
            echo $e->getMessage();
            return false;
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
}
