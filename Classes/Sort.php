<?
namespace Classes;

use Classes\Request;
class Sort{
    private $_sort, $_sort_by,$_links;
    public $sort_var_name = "sort";
    public $direction = "ASC";
    function __construct(array $sort) {
        $this->_sort = $sort;
        $rq = new Request();
        if(is_array($this->_sort) && $rq->get($this->sort_var_name) ){
            $this->_sort_by = $rq->get($this->sort_var_name);
        }
        $this->makeLinks($rq);
    }
    private function makeLinks(Request &$request){
        if(is_array($this->_sort)){
            foreach($this->_sort as $fName => $label){
                $this->_links[] = [
                    "label" => $label,
                    "link" => $request->getUrl()."?".$request->addPageParam($this->sort_var_name, $fName),
                    "active" => $request->get($this->sort_var_name) == $fName ? true : false
                ];
            }
            $this->_links[] = [
                "label" => "default",
                "link" =>$request->getUrl()."?".$request->delPageParam($this->sort_var_name),
                "active"=> !$request->get($this->sort_var_name) ? true : false
                ];
        }
        return $this;
    }
    function getLinks(){
        return $this->_links;
    }
    function getQuery(){
        if($this->_sort_by){
            return "ORDER BY ".$this->_sort_by." ".$this->direction;
        }    
    }
}