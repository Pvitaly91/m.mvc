<?

namespace Classes;

use Classes\Routing;
use Classes\Request;

class Paginator {

    public $cur_page, $next_page, $prev_page, $page_count, $url, $var_name, $next_url, $prev_url, $elements_on_page, $elements, $first_url, $last_url;

    public function __construct(\Classes\Model &$model) {
       
        $rq = new Request();
   
        $this->url = Routing::getInstance()->getUrl();
        $this->cur_page = $model->cur_page;
        $this->var_name = $model->pager_var_name;
        $this->elements = $model->elements;
        $this->elements_on_page = $model->elements_on_page;
      //  $p = (int)($model->elements / $model->elements_on_page);
        //$p == 0 ? $this->page_count = 1 : $this->page_count = $p;
       $this->page_count =  round(($model->elements / $model->elements_on_page), 0, PHP_ROUND_HALF_EVEN);
        if($this->page_count > 0){
            $this->first_url = $this->url."?".$rq->delPageParam($this->var_name);
            $rq->delPageParam($this->var_name) ? $this->first_url = $this->url."?".$rq->delPageParam($this->var_name) : $this->first_url = $this->url;
            $this->last_url = $this->url . "?" . $rq->addPageParam($this->var_name, $this->page_count);
            if ($this->cur_page == 1) {
                $this->next_page = $this->cur_page + 1;
                $this->next_url = $this->url . "?" . $rq->addPageParam($this->var_name, $this->next_page);
            } elseif ($this->cur_page > 1) {
                $this->prev_page = $this->cur_page - 1;

                $this->prev_url = $this->url . "?" . $rq->addPageParam($this->var_name, $this->prev_page);

                if ($this->page_count > $this->cur_page) {
                    $this->next_page = $this->cur_page + 1;
                    $this->next_url = $this->url . "?" . $rq->addPageParam($this->var_name, $this->next_page);
                }
            }
        }
    }

}
