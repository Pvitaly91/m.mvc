<?

namespace Classes;

class Request {

    private $_request, $_files, $_fields, $_get;

    function __construct() {
        $this->_request = $_REQUEST;
        $this->_get = $_GET;
        if (is_array($_FILES)) {
            $this->_files = $_FILES;
        }
        $this->makeFields();
    }

    private function makeFields() {
        if (is_array($this->_request)) {
            foreach ($this->_request as $name => $value) {
                $this->_fields[$name] = strip_tags(trim($value));
            }
        }
        if (is_array($this->_files)) {
            foreach ($this->_files as $name => $file) {
                $this->_fields[$name] = $file;
            }
        }
    }

    public function getFileds($name = false) {
        if ($name && isset($this->_fields[$name]) &&  $this->_fields[$name]){
            return $this->_fields[$name];
        }    
        return $this->_fields;
    }

    public function get($name = false) {
        if ($name && isset($this->_get[$name]) && !empty($this->_get[$name])){
            return strip_tags(trim($this->_get[$name]));
        }elseif(!$name){
            return $this->_get;
        }
    }
    function addPageParam($name,$value){
        
        $result = $this->get();
        
        $result[$name] = $value;
        return http_build_query($result);
    }
    function delPageParam($name){
        
        $result = $this->get();
        if(isset($result[$name])){
            unset($result[$name]);
        }
        
        return http_build_query($result);
    }
    function getUrl(){
        return $_SERVER['REDIRECT_URL'];
    }
}
