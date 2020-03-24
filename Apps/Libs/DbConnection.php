<?php

class Apps_Libs_DbConnection{
    protected $username = "root";
    protected $password = "";
    protected $host = "localhost";
    protected $database = "Quiz_Game";
    protected $tableName;
    protected $queryParams = []; //Query saves as params = []
    protected static $connectionInstance = null; //check connection status.

    public function __construct()
    {
        $this->connect(); //connect database when get a connect object.
    }

    public function BuildCondition ($condition){
        if (trim($condition)) //condition không rỗng.
        {
            return "where ".$condition;
        }
        else {
            return "";
        }
    }

    public function BuildOder ($oder){
        if (trim($oder)) //condition không rỗng.
        {
            return "ORDER BY ".$oder;
        }
        else {
            return "";
        }
    }
    public function connect () {
        if (self::$connectionInstance === null){ //When null isn't connected, the static will be called.
            // Push instance into connected status.
            try {
                self::$connectionInstance = new PDO ("mysql:host=$this->host;dbname=$this->database", $this->username, $this->password);
            }
            catch (PDOException $e) { //default.
                echo $e->getMessage();
                exit();
            }
        }
        return self::$connectionInstance;
    }
    public function query ($sql, $param = []){
        $q = self::$connectionInstance->prepare("$sql");
            if (is_array($param) && $param){
                $q->execute($param);
            }
            else{
                $q->execute();
            }
            return $q;
    }

    public function buildQueryParams ($params){
        $default = [
            "select" => "*",
            "where" => "",
            "other" => "",
            "params" => "",
            "field" => "",
            "inner" => "",
            "value" => []
        ];
        $this->queryParams = array_merge($default, $params);
        return $this;

        //queryParams lưu trữ giá trị lệnh.
        // Ví dụ: Select * where id = 0 thì queryParams = [
        // " select' = 0
        // "where" = "id = 0"
        // other = '' và params = "". Các chỉ số trước là index của mảng.
        //];
    }
    public function select (){
        $sql = "select ".$this->queryParams["select"]." from ".$this->tableName." ".$this->BuildCondition($this->queryParams["where"]). " ". $this->queryParams["other"];
//        echo ($sql);
        $query = $this->query($sql, $this->queryParams["params"]);
        return $query->fetchAll(PDO::FETCH_ASSOC);

    }
    public function inner (){
        $sql = "select ".$this->queryParams["select"]." from ".$this->queryParams["inner"]." ".$this->BuildCondition($this->queryParams["where"]). " ".$this->BuildOder($this->queryParams["other"]);
//        echo ($sql);
        $query = $this->query($sql, $this->queryParams["params"]);
        return $query->fetchAll(PDO::FETCH_ASSOC);

    }
    public function insert (){
        $sql = "insert into " .$this->tableName." ".$this->queryParams["field"];
        $result = $this->query($sql, $this->queryParams["value"]);
        echo ($sql);
        if ($result){
            return self::$connectionInstance->lastInsertId();
        }
        else {
            return false;
        }
    }

    public function update(){
        $sql = "update ".$this->tableName. " set ".$this->queryParams["value"]. " ".
        $this->BuildCondition($this->queryParams["where"]). " ".$this->queryParams["other"];
        return $this->query($sql, $this->queryParams["params"]);

        }

    public function Delete (){
        $sql = "delete from ".$this->tableName. " ". $this->BuildCondition($this->queryParams["where"])." ".$this->queryParams["other"];
        return $this->query($sql, $this->queryParams["params"]);

    }
}