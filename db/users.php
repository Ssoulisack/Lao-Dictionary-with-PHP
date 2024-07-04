<?php
require_once "config.php";
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
            $passwordHash = md5($password);
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
            $passwordHash = md5($password);
            $sql = "INSERT INTO member (username, firstname, lastname, email, password, address, telephone, urole) VALUES (:username, :fname, :lname, :email, :password, :address, :tel, :urole)";
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
    //Check Email and Username profile.php
    function checkEmail($email)
    {
        try {
            $sql = "SELECT COUNT(*) as num 
            FROM (
                SELECT email FROM member WHERE email = :email
                UNION ALL
                SELECT email FROM admin WHERE email = :email
                UNION ALL
                SELECT email FROM expert_language WHERE email = :email
            ) AS combined_results";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":email", $email);
            $stmt->execute();
            $result = $stmt->fetch();
            return $result;

        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    function checkUsername($username)
    {
        try {
            $sql = "SELECT COUNT(*) as num 
            FROM (
                SELECT username FROM member WHERE username = :username
                UNION ALL
                SELECT username FROM admin WHERE username = :username
                UNION ALL
                SELECT username FROM expert_language WHERE username = :username
            ) AS combined_results";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":username", $username);
            $stmt->execute();
            $result = $stmt->fetch();
            return $result;

        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    
    //check password
    function checkPassword($password)
    {
        try {
            $passwordHash = md5($password);
            $sql = "SELECT COUNT(*) as num
            FROM (
                SELECT password FROM member WHERE password = :password
                UNION ALL
                SELECT password FROM admin WHERE password = :password
                UNION ALL
                SELECT password FROM expert_language WHERE password = :password
            ) AS combined_results";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":password", $passwordHash);
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
            $passwordHash = md5($password);
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
    function loginAdmin($username, $password)
    {
        try {
            $sql = "SELECT * FROM admin WHERE username=:username AND password=:password";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":password", $password);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;

        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    //Function Login by ExpertLanguage
    function loginExpertLanguage($username, $password)
    {
        try {
            $sql = "SELECT * FROM expert_language WHERE username=:username AND password=:password";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":password", $password);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;

        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    //Function Login by member
    function loginMembers($username, $password)
    {
        try {
            $sql = "SELECT * FROM member WHERE username=:username AND password=:password";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":password", $password);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;

        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    //Approve Expert Language
    function eplRequest($status)
    {
        try {
            $sql = "SELECT * FROM expert_language WHERE status = :status";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":status", $status);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
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

    function infoUser($id, $username, $urole)//profile.php
    {
        try {
            if ($urole == 'admin') {
                $sql = "SELECT * FROM admin WHERE admin_id = :admin_id AND username = :username";
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(":admin_id", $id);
                $stmt->bindParam(":username", $username);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                return $result;
            } else if ($urole == 'member') {
                $sql = "SELECT * FROM member WHERE m_id = :m_id AND username = :username";
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(":m_id", $id);
                $stmt->bindParam(":username", $username);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                return $result;
            } else if ($urole == 'languageExpert') {
                $sql = "SELECT * FROM expert_language WHERE e_id = :e_id AND username = :username";
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(":e_id", $id);
                $stmt->bindParam(":username", $username);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                return $result;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            // echo $e->getMessage();
            return false;
        }
    }
    function members(){//members.php
        try {
            $sql = "SELECT * FROM member";
            $result = $this->db->query($sql);
            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    function epLanguage()//ep_languages.php
    {
        try {
            $sql = "SELECT * FROM expert_language WHERE status = 'approve'";
            $result = $this->db->query($sql);
            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    //Delete Function
    function deleteMember($id){
        try{
            $sql = "DELETE FROM member WHERE m_id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam("id",$id);
            $stmt->execute();
            return true;

        }catch(PDOException $e){
            echo $e->getMessage();
            return false;
        }
    }
    function deleteEpl($id){
        try{
            $sql = "DELETE FROM expert_language WHERE e_id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam("id",$id);
            $stmt->execute();
            return true;

        }catch(PDOException $e){
            echo $e->getMessage();
            return false;
        }
    }
    //Edited INFORMATION USERS
    function editInfo($user_id, $username, $email, $fname, $lname, $tel, $address, $urole)
    {
        try {
            if($urole === "languageExpert"){
                $sql = "UPDATE expert_language
                SET username = :username, email = :email, firstname = :fname, lastname = :lname, address = :address, telephone = :telephone
                WHERE e_id= :id";
            }elseif($urole === "admin"){
                $sql = "UPDATE admin
                SET username = :username, email = :email, firstname = :fname, lastname = :lname, address = :address, telephone = :telephone
                WHERE admin_id= :id";
            }else{
                $sql = "UPDATE member
                SET username = :username, email = :email, firstname = :fname, lastname = :lname, address = :address, telephone = :telephone
                WHERE m_id= :id";
            }
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":fname", $fname);
            $stmt->bindParam(":lname", $lname);
            $stmt->bindParam(":address", $address);
            $stmt->bindParam(":telephone", $tel);
            $stmt->bindParam(":id", $user_id);
            $stmt->execute();
            return true;

        } catch (PDOException $e) {
            // echo $e->getMessage();
            return false;
        }
    } 
}
