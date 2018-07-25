<?

namespace Classes;

use Classes\Request;
use Classes\Db;

Class User {

    use \Classes\Singleton;

    private $_app_token = "3495160884b68175612f71696f62a9e2";
    private $_permission = "guest";
    private $_user_name = "guest";
    private $_token;
    private $_user_id =false;

    
    public function login(Request $request) {
        $password = md5($request->getFileds("password") . $this->_app_token);
        $result = Db::getInstance()->query("SELECT `id`,`login`,`permission`,`token` FROM `users` WHERE login='" . $request->getFileds("login") . "' AND password='" . $password . "'")->fetch()[0];
        $this->setData($result);
        $this->sendSession();
        return $this;
    }
    public function getPr(){
        return $this->_permission;
    }
    public function sendSession() {
        $_SESSION["user"] = $this->_token;
        return $this;
    }

    public function checkLogin() {
        if (isset($_SESSION["user"])) {
            $result = Db::getInstance()->query("SELECT `id`,`login`,`permission`,`token` FROM `users` WHERE token='" . $_SESSION["user"] . "'")->fetch();
            isset($result[0]) ? $result = $result[0] : $result = false;
            $this->setData($result);
        }
        return $this;
    }
    private function setData($result){
        $this->_user_id = $result["id"];
        $this->_user_name = $result["login"];
        $this->_permission = $result["permission"];
        $this->_token = $result["token"];
        
    }
    public function getid(){
        return $this->_user_id;
    }
    public function logout(){
        unset($_SESSION["user"]);
        return $this;
    }
    public function getLogin(){
        return $this->_user_name;
    }
}
