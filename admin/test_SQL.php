<?php

echo "TEST SQL" . "\n";

class DB extends Apps_Libs_DbConnection {
    protected $tableName = [];

    /**
     * @param array $tableName
     */
    public function setTableName($tableName)
    {
        $this->tableName = $tableName;
    }

    /**
     * @return array
     */
    public function getTableName()
    {
        return $this->tableName;
    }
}
//$db = new DB();
//$query = $db->buildQueryParams([
//    "value" => "name=:name",
//    "where" => "id=:id",
//    "params" => [
//        ":name" => "Thu Duc2",
//        ":id" => "2"
//    ]
//])->update();


$db = new DB();
$db ->setTableName(["bảng 1", "bảng 2"]);
$result = $db->getTableName();
var_dump($result[0]);
