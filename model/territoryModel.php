<?php

/**
 * territoryModel
 *
 * @author DartVadius
 */
class territoryModel extends baseModel {

    public static $tableName = 't_koatuu_tree';

    /**
     * find list of cityes in region
     *
     * @param int $id region id
     * @return boolean | array
     */
    public function findChillrenCity($id) {
        $regId = $this->findRegId($id);
        if ($regId == '80' || $regId == '85') {
            $sql = "SELECT * FROM " . self::$tableName . " WHERE reg_id = $regId
               AND  ter_type_id IN (1, 3) AND ter_pid IS NOT NULL ORDER BY ter_type_id, ter_name";
        } else {
            $sql = "SELECT * FROM " . self::$tableName . " WHERE reg_id = $regId
               AND  ter_type_id IN (1, 2) AND ter_pid IS NOT NULL ORDER BY ter_type_id, ter_name";
        }

        $res = $this->pdo->prepare($sql);
        $res->execute($arr);
        $child = $res->fetchAll();

//        $sql = "SELECT child.* FROM " . self::$tableName .
//                " AS child LEFT JOIN " . self::$tableName .
//                " AS parent ON parent.ter_id = child.ter_pid WHERE child.reg_id = :id
//                AND child.ter_type_id IN (1, 2, 3) ORDER BY ter_type_id, ter_name";
//        $arr = [
//            'id' => $this->findRegId($id),
//        ];
//
//        $res = $this->pdo->prepare($sql);
//        $res->execute($arr);
//        $child = $res->fetchAll();
        if (!empty($child)) {
            return $child;
        } else {
            return FALSE;
        }
    }

    /**
     * list of city districts
     *
     * @param int $id
     * @return boolean | array
     */
    public function findCityDistrict($id) {
        if ($this->findTerType($id) == '1' || $this->findTerType($id) == '0') {
            $sql = "SELECT child.* FROM " . self::$tableName .
                    " AS child LEFT JOIN " . self::$tableName .
                    " AS parent ON parent.ter_id = child.ter_pid WHERE child.ter_pid = :id
                AND child.ter_type_id = 3 ORDER BY ter_name";
        } else {
            $sql = "SELECT child.* FROM " . self::$tableName .
                    " AS child LEFT JOIN " . self::$tableName .
                    " AS parent ON parent.ter_id = child.ter_pid WHERE child.ter_pid = :id
                AND child.ter_type_id IN (4, 5, 6) ORDER BY ter_type_id, ter_name";
        }

        $arr = [
            'id' => $id,
        ];

        $res = $this->pdo->prepare($sql);
        $res->execute($arr);
        $child = $res->fetchAll();
        if (!empty($child)) {
            return $child;
        } else {
            return FALSE;
        }
    }

    /**
     * list of regions
     *
     * @return boolean | array
     */
    public function findRegion() {
        $sql = "SELECT ter_id, ter_name  FROM " . self::$tableName . " WHERE ter_pid IS NULL ORDER BY ter_name";
        $res = $this->pdo->query($sql);
        $reg = $res->fetchAll();
        if (!empty($reg)) {
            return $reg;
        } else {
            return FALSE;
        }
    }

    /**
     * find address by region id
     *
     * @param int $id
     * @return boolean | string
     */
    public function findAddressById($id) {
        $sql = "SELECT ter_address  FROM " . self::$tableName . " WHERE ter_id = :ter_id";
        $arr = [
            'ter_id' => $id,
        ];
        $res = $this->pdo->prepare($sql);
        $res->execute($arr);
        $child = $res->fetchColumn();
        if (!empty($child)) {
            return $child;
        } else {
            return FALSE;
        }
    }

    public function findTerType($id) {
        $sql = "SELECT ter_type_id FROM " . self::$tableName . " WHERE ter_id = :ter_id";
        $arr = [
            'ter_id' => $id,
        ];
        $res = $this->pdo->prepare($sql);
        $res->execute($arr);
        $type = $res->fetchColumn();
        if (!empty($type)) {
            return $type;
        } else {
            return FALSE;
        }
    }

    public function findRegId($id) {
        $sql = "SELECT reg_id FROM " . self::$tableName . " WHERE ter_id = :ter_id";
        $arr = [
            'ter_id' => $id,
        ];
        $res = $this->pdo->prepare($sql);
        $res->execute($arr);
        $type = $res->fetchColumn();
        if (!empty($type)) {
            return $type;
        } else {
            return FALSE;
        }
    }

}
