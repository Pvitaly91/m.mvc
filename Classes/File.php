<?

namespace Classes;

class File {

    protected $_name, $_field, $_type, $_tmp_name, $_size,$_root_dir,$_root_tmp_dir,$_error;
    protected $app_dir_path = "/Data/uploads";
    protected $tmp_dir = "/Data/uploads/tmp";
    protected $destenation_tmp_name;
    public function __construct(array $file, $field) {
        
        $this->_root_dir = $_SERVER["DOCUMENT_ROOT"].$this->app_dir_path;
        $this->_root_tmp_dir = $_SERVER["DOCUMENT_ROOT"].$this->tmp_dir;
       
        $this->_field = $field;
       
        foreach ($file as $k => $v) {
            $prp_name = "_" . $k;
            if (property_exists($this, $prp_name)) {
                $this->{$prp_name} = $v;
            }
        }
         $this->destenation_tmp_name = $this->_root_tmp_dir."/".basename($this->_name);
    }

    public function getName() {
        return $this->_name;
    }

    public function getField() {
        return $this->_field;
    }

    public function getType() {
        return $this->_type;
    }

    public function getSize() {
        return $this->_size;
    }

    public function move() {
     
        move_uploaded_file($this->_tmp_name, $this->destenation_tmp_name);
       
    }
    public function getDirPath(){
        return $this->_root_dir;
    }
    public function getFileUrl(){
        return $this->app_dir_path."/".$this->_name;
    }
    public function getError(){
        return $this->_error;
    }
}
