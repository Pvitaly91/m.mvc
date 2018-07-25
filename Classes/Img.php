<?

namespace Classes;

use Classes\File;

class Img extends File {

    private $_avall_type = ["image/jpeg", "image/png", "image/gif"];
    private $_img_format = ["image/jpeg" => ".jpg", "image/png" => ".png", "image/gif" => ".gif"];
    private $_tmp_file_name = "tmp";
    private $_root_img_path;
    private $_root_tmp_file;
    private $thumb, $width, $height;
    public function __construct(array $file, $field) {
        $this->app_dir_path = "/Data/img";
        
        parent::__construct($file, $field);
        if (!in_array($this->_type, $this->_avall_type)) {
            $this->_error = "type mast be jpg,png,gif";
        }
        $this->_root_img_path = $this->_root_dir."/".$this->_name;
        if(isset($this->_img_format[$this->_type])){
            $this->_tmp_file_name = $this->_tmp_file_name.$this->_img_format[$this->_type];
            $this->_root_tmp_file = $this->_root_tmp_dir."/".$this->_tmp_file_name;
        }
    }

    public function move() {
        if (isset($this->_img_format[$this->_type])) {
            $this->destenation_tmp_name = $this->_root_tmp_dir . "/" . $this->_tmp_file_name . $this->_img_format[$this->_type];
            parent::move();
        }
    }
    public function calculateSize(&$newwidth,&$newheight){
        if($newwidth < $this->width ){
            $koef = $newwidth/$this->width;
        }elseif($newwidth > $this->width && $newheight < $this->height){
            $koef = $newheight/$this->height;
        }else{
            $koef = $newwidth/$this->width;
        }
        $newheight = $this->height*$koef;
   
    }
    public function getResized($newwidth, $newheight=false) {
        // файл и новый размер
       
       
     //   header('Content-Type: image/jpeg');
        list($this->width, $this->height) = getimagesize($this->_tmp_name);
      
       $this->calculateSize($newwidth, $newheight);
        // загрузка
        $this->thumb = imagecreatetruecolor($newwidth, $newheight);
        $source = imagecreatefromjpeg($this->_tmp_name);

        // изменение размера
        imagecopyresized($this->thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $this->width, $this->height);

        // вывод
     //  imagejpeg($this->thumb);
        return $this;
    }
    public function renderImg(){
        header('Content-Type: image/jpeg');
        imagejpeg($this->thumb);
    }
    public function saveImg($tmp_file =false){
        if($tmp_file){
            
            imagejpeg($this->thumb,$this->_root_tmp_file);
        }else{
            imagejpeg($this->thumb,$this->_root_img_path);
        }
    }
    public function getTmpImgUrl(){
        return $this->tmp_dir."/".$this->_tmp_file_name;
    }

    // public function 
}
