<?php

/**
 * territoryModel
 *
 * @author DartVadius
 */
class territoryModel extends baseModel {

    public static $tableName = 't_koatuu_tree';

    /**
     * find chilrdren by parent id
     *
     * @param int $id
     * @return boolean | array
     */
    public function findChildrenById($id) {
        $sql = "SELECT child.* FROM " . self::$tableName .
                " AS child LEFT JOIN " . self::$tableName .
                " AS parent ON parent.ter_id = child.ter_pid WHERE child.ter_pid = :id ORDER BY ter_name";
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
     * find list of cityes in region
     *
     * @param int $id region id
     * @return boolean | array
     */
    public function findChillrenCity($id) {
        $sql = "SELECT child.* FROM " . self::$tableName .
                " AS child LEFT JOIN " . self::$tableName .
                " AS parent ON parent.ter_id = child.ter_pid WHERE child.ter_pid = :id
                AND child.ter_type_id = 1 ORDER BY ter_name";
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
     * list of city districts
     *
     * @param int $id
     * @return boolean | array
     */
    public function findCityDistrict($id) {
        $sql = "SELECT child.* FROM " . self::$tableName .
                " AS child LEFT JOIN " . self::$tableName .
                " AS parent ON parent.ter_id = child.ter_pid WHERE child.ter_pid = :id
                AND child.ter_type_id = 3 ORDER BY ter_name";
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

}
