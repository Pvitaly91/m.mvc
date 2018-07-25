<?

namespace App\Controllers;

use Classes\Routing;
use Classes\Msg;
abstract class BaseController {

    private $layout = "default";
    private $views = [];
    private $_permissions =[];
    
    public function indexAction() {
        return $this->render();
    }
    protected function addPermission($action, $name){
        $this->_permissions[$action] = $name;
    }
    public function getPermission($action){
        if(isset($this->_permissions[$action])){
            return $this->_permissions[$action];
        }
    }

    public function setLayout($layoutName){
        $this->layout = $layoutName;
    }
    /**
     * Action for 404 page
     * @return type
     */
    public function notfoundAction(){
        header("HTTP/1.0 404 Not Found");
        return $this->addView("404")->render();
    }
    
    public function addView($viewName, $data = array(),$blockName = "content") {
        if(!isset($this->views[$blockName])){
            $this->views[$blockName] = "";
        }
        $data["msg_success"] = Msg::getInstance()->getSuccess();
        $data["msg_errors"] = Msg::getInstance()->getError();
        if (is_array($data)){ 
            extract($data);
        }
        ob_start();
        require $_SERVER["DOCUMENT_ROOT"] . '/App/Views/'.$viewName.".php";
        $this->views[$blockName] .= ob_get_clean();
        return $this;
    }
    
    public function getViews() {
        return $this->views;
    }

    public function render($data = false) {
        extract($this->views);
        if (is_array($data)) {
            extract($data);
        }
        ob_start();
        require $_SERVER["DOCUMENT_ROOT"] . '/App/Views/Layouts/' . $this->layout . ".php";
        return ob_get_clean();
    }
    public function renderView($viewName,$data= false){
    
        if (is_array($data)){ 
            extract($data);
        }
        ob_start();
        require $_SERVER["DOCUMENT_ROOT"] . '/App/Views/'.$viewName.".php";
        return ob_get_clean();
    }
    public function redirct($url){
        header('Location: '.$url);
    }
}
