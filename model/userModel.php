<?php

/**
 * userModel
 *
 * @author DartVadius
 */
class userModel extends baseModel {

    public static $tableName = 'user';
    private $id = NULL;
    private $name = NULL;
    private $email = NULL;
    private $territory = NULL;

    public function __construct($name, $email, $territory) {
        parent::__construct();
        $this->name = $name;
        $this->email = $email;
        $this->territory = $territory;
    }

    /**
     *
     * @return boolean | int
     */
    public function save() {
        $sql = "INSERT INTO " . self::$tableName . "  SET
            name = :name,
            email = :email,
            territory = :territory";
        $arr = [
            'name' => $this->name,
            'email' => $this->email,
            'territory' => $this->territory,
        ];
        $res = $this->pdo->prepare($sql);
        try {
            $res->execute($arr);
            $lastId = $this->pdo->lastInsertId();
            return $lastId;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return FALSE;
        }
    }

    /**
     * check the presence of user in DB by email
     *
     * @return boolean | array
     */
    public function findByEmail() {
        $sql = "SELECT * FROM " . self::$tableName . "  WHERE email = :email";
        $arr = [
            'email' => $this->email,
        ];
        $res = $this->pdo->prepare($sql);
        $res->execute($arr);
        $child = $res->fetch();
        //var_dump($child);
        if (!empty($child)) {
            return $child;
        } else {
            return FALSE;
        }
    }

    public function getTerritory() {
        return $this->territory;
    }

}
