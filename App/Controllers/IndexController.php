<?

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Tasks;
use Classes\Paginator;
use Classes\Sort;
use Classes\Request;
use Classes\User;
use Classes\Msg;
class IndexController extends BaseController {

    public function indexAction() {

        $model = new Tasks();
        $model->elements_on_page = 3;
        $sort = new Sort(["name" => "Name", "email" => "E-mail", "status" => "Status"]);
     
        $model->getElemntsCount();
        $items = $model->select(["id", "name", "email", "task_text", "image","status"])->queryParam($sort->getQuery()." ".$this->getLimit($model))->get();
       
        if(is_array($items)){
            foreach ($items as  &$item){
                $item["status"] > 0 ? $item["status"] ="Done" : $item["status"] = "Not done";
            }
        }

        $pager = new Paginator($model);
       
        return $this->addView("list", [
                                        "items" => $items,
                                        "sort" => $this->renderView("sort", ["sort" => $sort->getLinks()])
                                    ])
                        ->addView("pager", ["pager" => $pager])
                        ->render();
    }

    public function getLimit(&$model) {

        if ($model->elements_on_page == false) {
            return "";
        } else {
            $model->cur_page == 1 ? $start = 0 : $start = ($model->cur_page * $model->elements_on_page) - $model->elements_on_page;
            $start < 0 ? $start = 0 : false;

            return "LIMIT " . $model->elements_on_page . " OFFSET " . $start;
        }
    }

    public function authAction() {
    
      //  d(md5("123admin3495160884b68175612f71696f62a9e2"));
        return $this->addView("auth")->render();
    }
    public function loginAction(Request $request){
        $user = User::getInstance();
      //  d($user->login($request)->getid());
        if($user->login($request)->getid())
        {
            Msg::getInstance()->addSuccess("<strong>Login</strong> you successfully authorized");
            $this->redirct("/");
        }else{
            Msg::getInstance()->addError("<strong>Fail!</strong> wrong login or password");
            $this->redirct("/auth");
        }
    }
    public function logoutAction(){
        User::getInstance()->logout();
        $this->redirct("/");
    }
}
