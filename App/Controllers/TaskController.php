<?

namespace App\Controllers;

use Classes\Request;
use App\Models\Tasks;
use App\Controllers\BaseController;
use Classes\Msg;
use Classes\Img;
class TaskController extends BaseController {
    public function __construct() {
        $this->addPermission("edit", "admin");
    }
    public function addAction() {
        $model = new Tasks();
  
        return $this->addView("add",$model->getInsertData())->render();
    }

    public function editAction($id) {
        $model = new Tasks();
        $item = $model->select(["id", "task_text", "status"])->getById($id)->get();
        if (isset($item[0])) {
            $item = $item[0];
        } else {
            return $this->notfoundAction();
        }
        return $this->addView("edit",["item" => $item])->render();
    }
    
    public function detailAction($id) {
        
        $model = new Tasks();
        $item = $model->getById($id)->get();
        if (isset($item[0])) {
            $item = $item[0];
        } else {
            return $this->notfoundAction();
        }
        return $this->addView("detail", ["item" => $item])->render();
    }

    /**
     * if action parameter type is Request, request method must be a POST
     * @param Request $request
     */
    public function insertAction(Request $request) {

        $model = new Tasks();
        $model->insert($request->getFileds());
  
        if(!$model->getErrors() && $model->save()){
            Msg::getInstance()->addSuccess("<strong>Success!</strong> new task added");
            $this->redirct("/");
        }elseif($model->getErrors()){
           
            $this->redirct("/task/add");
        }
     
    }
    public function updateAction(Request $request,$id) {
      
        $model = new Tasks();
        if($model->update($request->getFileds(), $id)->save()){
            Msg::getInstance()->addSuccess("<strong>Success!</strong> task updated");
            $this->redirct("/");
        }
    }
    public function previewAction(Request $request){
        $fileds = $request->getFileds();
       if (is_array($fileds["image"])) {
            $img = new Img($fileds["image"], "image");
            if (!$img->getError()) {
               $img->getResized(320,240)->saveImg(true);
               $fileds["image"] = $img->getTmpImgUrl();
            }
        }
        foreach ($fileds as $k => $field){
            if(!$field || is_array($field)){
                unset($fileds[$k]);
            }
        }
        return $this->renderView("detail", ["item" => $fileds]);
    }

 

}
