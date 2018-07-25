<?

namespace Classes;

use App\Controllers\BaseController;
use Classes\Request;
use Classes\User;
class Routing {

    use \Classes\Singleton;

    private $_controller, $_action, $_parametrs, $_html, $_splits, $_url, $_request_uri;
    public $action;
    private function __construct() {
        $ull_part = explode("?",$_SERVER["REQUEST_URI"]);
        $this->_url= $ull_part[0];
        $this->_request_uri = $_SERVER["REQUEST_URI"];
        $this->_splits = explode('/', trim($this->_url, '/'));
        !empty($this->_splits[0]) ? $this->setController($this->_splits[0]) : $this->setController("index");
        !empty($this->_splits[1]) ? $this->setAction($this->_splits[1]) : $this->setAction('index');
        count($this->_splits) > 2 ? $this->_parametrs = array_slice($this->_splits, 2) : $this->_parametrs = [];
        (!empty($this->_splits[0]) && count($this->_splits) == 1) ? $this->setAction($this->_splits[0]) : false;
        $user = User::getInstance()->checkLogin();
      
    }

    private function setController($name) {
        $this->_controller = "App\Controllers\\" . ucfirst($name) . 'Controller';
        return $this;
    }

    private function setAction($name) {
        $this->action = $name;
        $this->_action = $name . 'Action';
        return $this;
    }
   
    public function getUrl(){
        return $this->_url;
    }
    public function getReqUri(){
        return $this->_request_uri;
    }
    public function set404(\ReflectionClass &$rc, BaseController &$controller) {
        $method = $rc->getMethod("notfoundAction");
        $this->setHtml($method->invoke($controller));
    }

    public function route() {
        $user = User::getInstance();
        if (!file_exists($_SERVER["DOCUMENT_ROOT"] . "/" . $this->getController() . ".php")) {
            $this->setController("index"); //set 404 page
        }
        $rc = new \ReflectionClass($this->getController());
        if ($rc->isSubclassOf("App\Controllers\BaseController")) {

            if (!$rc->hasMethod($this->getAction())) {
                $this->setAction("notfound"); //set 404 page
            }
            $controller = $rc->newInstance();
            $permission = $rc->getMethod("getPermission");

            $pr = $permission->invokeArgs($controller, [$this->action]);//check permission for action
            if(!$pr || $user->getPr() == $pr ){ 
                $method = $rc->getMethod($this->getAction());
                $params = $method->getParameters();

                if ($params) {
                    if ((string) $params[0]->getType() == "Classes\Request" && $_SERVER["REQUEST_METHOD"] == "POST") {
                        array_unshift($this->_parametrs, new Request());  
                    }
                    if (!empty($this->_parametrs) && count($params) == count($this->_parametrs)) {

                        $this->setHtml($method->invokeArgs($controller, $this->_parametrs));
                    } else {
                        $this->set404($rc, $controller);
                    }
                } else {
                    $this->setHtml($method->invoke($controller));
                }
            }else{
                $this->setHtml("accsess denine");
            }    
        } else {
            throw new \Exception("Controller");
        }
        return $this;
    }

    public function setHtml($html) {
        $this->_html = $html;
        return $this;
    }

    public function getHtml() {
        return $this->_html;
    }

    public function getController() {
        return $this->_controller;
    }

    public function getAction() {
        return $this->_action;
    }

    public function render() {
        echo $this->_html;
    }

}
