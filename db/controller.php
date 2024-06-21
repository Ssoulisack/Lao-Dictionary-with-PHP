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
    //allVocab
    function allVocab($start, $rows_per_page){
        try {
            $sql = "SELECT * FROM vocabulary ORDER BY vocabulary ASC LIMIT $start, $rows_per_page";
            $stmt = $this->db->query($sql);
            return $stmt;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    function vocabNumrow()//Num row questions_page.php
    {
        try {
            $sql = "SELECT COUNT(*) FROM vocabulary";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $rowCount = $stmt->fetchColumn();
            return $rowCount;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    //GET part of speech
    function getPos(){
        try {
            $sql = "SELECT * FROM parts_of_speech";
            $stmt = $this->db->query($sql);
            return $stmt;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    //Show info Characters & Part of speech
    function infoCharacter()//(logging/add_vocab & character_info_login & character_info & vocab_info_login & vocab_info) 
    {
        try {
            $sql = "SELECT * FROM Characters";
            $stmt = $this->db->query($sql);
            return $stmt;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    function infoPos() //(logging/add_vocab & character_info_login & character_info & vocab_info_login & vocab_info)
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

    function selectVocab()
    {
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

    function insert($user_id, $vocabulary, $character_id, $pos_id, $definition, $example) //Insert Vocab (logging/add_vocab.php)
    {
        try {
            if ($_SESSION['urole'] == 'admin') {
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
            } else {
                $sql1 = "INSERT INTO vocabulary (vocabulary, character_id, e_id) VALUES (:vocabulary, :character_id, :e_id)";
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

    // ***********SEARCH VOCAB******************* (search.php & searchLogin.php)
    function searchVocab($vocabulary)
    {
        try {
            $vocab = '%' . $vocabulary . '%';
            $sql = "SELECT v_id, vocabulary FROM vocabulary 
            WHERE vocabulary LIKE :vocab";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":vocab", $vocab);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;

        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    function getAllVocab() //(result & result_login)
    {
        try {
            $sql = "SELECT * FROM vocabulary";
            $result = $this->db->query($sql);
            return $result;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    // INFORMATION VOCAB
    function showVocab($character_id)
    {
        try {
            $sql = "SELECT 
            b.v_id, 
            b.vocabulary, 
            d.characters
            FROM vocabulary b
            INNER JOIN characters d ON b.character_id = d.character_id
            WHERE b.character_id = :character_id;";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":character_id", $character_id);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            return false;
        }
    }
    //Detail definition & example
    function showDetail($vocab_id)
    {
        try {
            $sql = "SELECT 
            b.v_id, 
            b.vocabulary,
            d.characters,
            a.definition_id,
            a.definition, 
            a.example,
            c.pos_id,
            c.pos_name2 
            FROM definition a 
            INNER JOIN vocabulary b ON b.v_id = a.v_id 
            INNER JOIN parts_of_speech c ON a.pos_id = c.pos_id 
            INNER JOIN characters d ON b.character_id = d.character_id 
            WHERE a.v_id = :v_id;";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":v_id", $vocab_id);
            $stmt->execute();
            $detail = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $detail;
            // return $stmt;
        } catch (PDOException $e) {
            return false;
        }
    }
    function showDetails($definition_id)//===================edit_info/edit_info.php
    {
        try {
            $sql = "SELECT 
            b.v_id, 
            b.vocabulary,
            a.definition_id,
            a.definition, 
            a.example,
            c.pos_id
            FROM definition a 
            INNER JOIN vocabulary b ON b.v_id = a.v_id 
            INNER JOIN parts_of_speech c ON a.pos_id = c.pos_id 
            WHERE a.definition_id = :definition_id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":definition_id", $definition_id);
            $stmt->execute();
            $detail = $stmt->fetch(PDO::FETCH_ASSOC);
            return $detail;
            // return $stmt;
        } catch (PDOException $e) {
            return false;
        }
    }
    //Detail Vocab (Page: vocab_info_login)
    function showVocabDetail($v_id)
    {
        try {
            $sql = "SELECT a.v_id, 
            a.vocabulary, 
            b.pos_id, 
            c.pos_name2 
            FROM vocabulary a 
            INNER JOIN definition b ON a.v_id = b.v_id 
            INNER JOIN parts_of_speech c ON b.pos_id = c.pos_id 
            WHERE a.v_id = :v_id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":v_id", $v_id);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            return false;
        }
    }

    /*---------------------EDIT VOCAB & DEFINITION (vocab_manage)--------------- */
    function editVocab($old_vocab, $new_vocab, $v_id, $user_id, $username, $urole, $status)
    {
        try {
            $sql = "INSERT INTO edit_vocab (new_vocab, old_vocab, v_id, user_id, username, urole, status) VALUES (:new_vocab, :old_vocab, :v_id, :user_id, :username, :urole, :status)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":new_vocab", $new_vocab);
            $stmt->bindParam(":old_vocab", $old_vocab);
            $stmt->bindParam(":v_id", $v_id);
            $stmt->bindParam(":user_id", $user_id);
            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":urole", $urole);
            $stmt->bindParam(":status", $status);
            $stmt->execute();
            $this->db = null;
            return true;

        } catch (PDOException $e) {
            return false;
        }
    }
    /* -----------------EDIT DEFINITION & EXAMPLE----------------------------- (Vocab_manage/vocab_info_login) */
    function editDefinition($definition_id, $pos_id, $v_id, $old_definition, $new_definition, $old_example, $new_example, $user_id, $username, $urole, $status)
    {
        try {
            $sql = "INSERT INTO edit_definition (old_definition, old_example, new_definition, new_example, definition_id, pos_id, v_id, user_id, username, urole, status) VALUES (:old_definition, :old_example, :new_definition, :new_example, :definition_id, :pos_id, :v_id, :user_id, :username, :urole, :status)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":old_definition", $old_definition);
            $stmt->bindParam(":old_example", $old_example);
            $stmt->bindParam(":new_definition", $new_definition);
            $stmt->bindParam(":new_example", $new_example);
            $stmt->bindParam(":definition_id", $definition_id);
            $stmt->bindParam(":pos_id", $pos_id);
            $stmt->bindParam(":v_id", $v_id);
            $stmt->bindParam(":user_id", $user_id);
            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":urole", $urole);
            $stmt->bindParam(":status", $status);
            $stmt->execute();
            $this->db = null;
            return true;

        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    /* -----------------ADD DEFINITION & EXAMPLE----------------------------- (Vocab_manage/vocab_info_login) */
    function addDefinition($pos_id, $definition_id, $new_definition, $new_example, $v_id, $user_id, $username, $urole, $status)
    {
        try {
            $sql = "INSERT INTO edit_definition (new_definition, new_example, definition_id, pos_id, v_id, user_id, username, urole, status) VALUES (:new_definition, :new_example, :definition_id, :pos_id, :v_id, :user_id, :username, :urole, :status)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":new_definition", $new_definition);
            $stmt->bindParam(":new_example", $new_example);
            $stmt->bindParam(":definition_id", $definition_id);
            $stmt->bindParam(":pos_id", $pos_id);
            $stmt->bindParam(":v_id", $v_id);
            $stmt->bindParam(":user_id", $user_id);
            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":urole", $urole);
            $stmt->bindParam(":status", $status);
            $stmt->execute();
            $this->db = null;
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /*=========================================Vocab Request=============================== */
    function vocabReq($status) //vocab_manage/listVocab_req.php
    {
        try {
            $sql = "SELECT * FROM edit_vocab 
            WHERE status = :status";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":status", $status);
            $stmt->execute();
            // $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            // return $result;
            return $stmt;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    function updateStt($user_id, $e_id, $status)//vocab_manage/lUpdate_reqVocab
    {
        try {
            $sql = "UPDATE edit_vocab SET verifyBy = :user_id, status = :status WHERE edit_id = :edit_id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":user_id", $user_id);
            $stmt->bindParam(":status", $status);
            $stmt->bindParam(":edit_id", $e_id);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    function confirmVocab($v_id, $new_vocab, $statusVocab)//vocab_manage/lUpdate_reqVocab
    {
        try {
            $sql = "UPDATE vocabulary SET vocabulary = :vocabulary, status = :status WHERE v_id = :v_id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":vocabulary", $new_vocab);
            $stmt->bindParam(":status", $statusVocab);
            $stmt->bindParam(":v_id", $v_id);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    function cancelVocab($id, $status, $verify_id)//vocab_manage/lCancel_vocab.php
    {
        try {
            // $sql = "DELETE FROM edit_vocab WHERE edit_id = :edit_id";
            $sql = "UPDATE edit_vocab SET status = :status, verifyBy = :verifyBy WHERE edit_id = :edit_id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":edit_id", $id);
            $stmt->bindParam(":verifyBy", $verify_id);
            $stmt->bindParam(":status", $status);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    function definitionReq($status)//vocab_manage/listEdit_req.php
    {
        try {
            $sql = "SELECT 
            a.edit_id,
            a.old_definition, 
            a.old_example, 
            a.new_definition, 
            a.new_example, 
            a.username, 
            a.status, 
            b.vocabulary,
            c.pos_name2 
            FROM edit_definition a 
            INNER JOIN vocabulary b ON a.v_id = b.v_id 
            INNER JOIN parts_of_speech c ON a.pos_id = c.pos_id 
            WHERE a.status = :status";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":status", $status);
            $stmt->execute();
            // $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stmt;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    function editDetail($id)//vocab_manage/editReq_detail.php
    {
        try {
            $sql = "SELECT 
            a.user_id,
            a.urole,
            a.edit_id,
            a.pos_id, 
            a.v_id, 
            a.old_definition, 
            a.old_example, 
            a.new_definition, 
            a.new_example, 
            a.username,
            a.definition_id, 
            b.vocabulary,
            c.pos_name2 
            FROM edit_definition a 
            INNER JOIN vocabulary b ON a.v_id = b.v_id 
            INNER JOIN parts_of_speech c ON a.pos_id = c.pos_id
            WHERE edit_id = :edit_id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":edit_id", $id);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
            // return $stmt;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    function updateStatus($edit_id, $verify_id, $status)//vocab_manage/update_info_vocab/update_definition.php 
    {
        try {
            $sql = "UPDATE edit_definition SET verifyBy = :verifyBy, status = :status WHERE edit_id = :edit_id;";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":verifyBy", $verify_id);
            $stmt->bindParam(":status", $status);
            $stmt->bindParam(":edit_id", $edit_id);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    function confirmDefinition($definition_id, $new_definition, $new_example, $pos_id, $v_id, $statusDefinition, $user_id)//vocab_manage/update_info_vocab/update_definition.php
    {
        try {
            $sql = "UPDATE definition SET 
            pos_id = :pos_id,
            definition = :definition,
            example = :example,
            v_id = :v_id,
            e_id = :e_id,
            status = :status
            WHERE definition_id = :definition_id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":pos_id", $pos_id);
            $stmt->bindParam(":definition", $new_definition);
            $stmt->bindParam(":example", $new_example);
            $stmt->bindParam(":v_id", $v_id);
            $stmt->bindParam(":e_id", $user_id);
            $stmt->bindParam(":status", $statusDefinition);
            $stmt->bindParam(":definition_id", $definition_id);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }

    }

    function confirmAdd_definition($pos_id, $new_definition, $new_example, $v_id, $user_id, $verify_id, $statusDefinition, $urole)//vocab_manage/update_info_vocab/add_definition.php
    {
        try {
            if ($urole == "admin") {
                $sql = "INSERT INTO definition (pos_id, definition, example, v_id, admin_id, e_id, status) VALUES (:pos_id, :definition, :example, :v_id, :admin_id, :e_id, :status) ";
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(":pos_id", $pos_id);
                $stmt->bindParam(":definition", $new_definition);
                $stmt->bindParam(":example", $new_example);
                $stmt->bindParam(":v_id", $v_id);
                $stmt->bindParam(":admin_id", $user_id);
                $stmt->bindParam(":e_id", $verify_id);
                $stmt->bindParam(":status", $statusDefinition);
                $stmt->execute();
                return true;
            } else if ($urole == "member") {
                $sql = "INSERT INTO definition (pos_id, definition, example, v_id, m_id, e_id, status) VALUES (:pos_id, :definition, :example, :v_id, :m_id, :e_id, :status) ";
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(":pos_id", $pos_id);
                $stmt->bindParam(":definition", $new_definition);
                $stmt->bindParam(":example", $new_example);
                $stmt->bindParam(":v_id", $v_id);
                $stmt->bindParam(":m_id", $user_id);
                $stmt->bindParam(":e_id", $verify_id);
                $stmt->bindParam(":status", $statusDefinition);
                $stmt->execute();
                return true;
            } else {
                $sql = "INSERT INTO definition (pos_id, definition, example, v_id, e_id, status) VALUES (:pos_id, :definition, :example, :v_id, :e_id, :status) ";
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(":pos_id", $pos_id);
                $stmt->bindParam(":definition", $new_definition);
                $stmt->bindParam(":example", $new_example);
                $stmt->bindParam(":v_id", $v_id);
                $stmt->bindParam(":e_id", $verify_id);
                $stmt->bindParam(":status", $statusDefinition);
                $stmt->execute();
                return true;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    function reject_req($edit_id, $statusReject, $verify_id)//vocab_manage/update_info_vocab/rejectMethod
    {
        try {
            $sql = "UPDATE edit_definition SET status = :status, verifyBy = :verifyBy WHERE edit_id = :edit_id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":edit_id", $edit_id);
            $stmt->bindParam(":status", $statusReject);
            $stmt->bindParam(":verifyBy", $verify_id);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
}