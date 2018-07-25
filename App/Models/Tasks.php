<?

namespace App\Models;

use Classes\Model;
use Classes\Img;
use Classes\Msg;
class Tasks extends Model {
   
    public function insert(array $fileds) {
        $this->setReqiredFileds(["name","email","task_text"]);
        if (is_array($fileds["image"])) {
            $img = new Img($fileds["image"], "image");
            
          
            if (!$img->getError()) {
                $img->getResized(320,240)->saveImg();
               $fileds["image"] = $img->getFileUrl();
            }else{
                $this->errors =true;
                Msg::getInstance()->addError("<strong>Error!</strong> image ".$img->getError());
            }
        }
       
        return parent::insert($fileds);
            
    }
   
    public function update(array $fileds, $id) {
        
        if(!isset($fileds["status"])){
            $fileds["status"] = "0";
        }
        return parent::update($fileds, $id);
    }
    

}
