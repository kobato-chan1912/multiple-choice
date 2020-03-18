<?php
class Apps_Libs_Router{
    const param_name = 'r';
    const home_page = 'home';
    const index_page = 'index';
    public static $sourcePath;

    public function __construct($sourcePath = "")
    {
        if ($sourcePath) {
            self::$sourcePath = $sourcePath;
        }
    }
    public function getGET ($name){
        if ($name!==NULL){
            return isset($_GET[$name]) ? $_GET[$name] : NULL;
        }
        return $_GET;
    }
    public function getPOST ($name){
        if ($name!==NULL){
            return isset($_POST[$name]) ? $_POST[$name] : NULL;
        }
        return $_POST;
    }
    public function Router (){
        // xác định url, tức phần tử sau.
        $url = $this->getGET(self::param_name); // get ra cái param name, tức phần tử sau.
        if (!$url || $url == self::index_page){
            $url = self::home_page;
        }
        $path = self::$sourcePath."/".$url.".php";
        if (file_exists($path)){
            return require_once $path;
        }
        else{
            echo "404 not found";
        }
    }

    public function createUrl($url, $params = []){
        if ($url){
            $params[self::param_name]=$url;
            return $_SERVER['PHP_SELF']."?".http_build_query($params);
        }
    }
    public function redirect ($url){
        $u = $this->createUrl($url);
        header("Location:$u");
    }

    public function homepage(){
        $this->redirect(self::home_page);
    }
    public function loginpage (){
        $this->redirect("login");
    }

}