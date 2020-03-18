<?php
session_start();

class Apps_Libs_UserIdentity
{
    public $username;
    public $password;

    public function __construct($username = "", $password = "")
    {
        $this->username = $username;
        $this->password = $password;
    }

    public function EncryptePass()
    {
        return md5($this->password);
    }

    public function login()
    {
        $db = new Apps_Models_users();
        $query = $db->buildQueryParams([ // chọn user, pass bỏ vao
//            "select" => "*",
            "where" => "username = :username AND password = :password",
            "params" => [
                ":username" => trim($this->username),
                ":password" => $this->EncryptePass()
            ]

        ])->select();

        if ($query) {
            $_SESSION["userId"] = $query[0]["id"];
            $_SESSION["username"] = $query[0]["username"];
            return true;
        }
        return false;
    }

    // trả về result dạng $query[id,user,pass];

    public function logout()
    {
        unset($_SESSION["userId"]);
        unset($_SESSION["username"]);
    }

    public function Get_Session_Name($name)
    {
        if ($name !== NULL) {
            return isset($_SESSION[$name]) ? $_SESSION[$name] : NULL;
        }
        return $_SESSION;
    }

    function isLogin()
    {
        if ($this->Get_Session_Name("userId")) { //Nếu tồn tại Session tên userid.
            return true;
        }
        return false;
    }

    public function getID()
    {
        return $this->Get_Session_Name("userId");
    }

}