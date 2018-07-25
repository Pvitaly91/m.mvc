<?

namespace Classes;

use Classes\Db;
use Classes\Msg;
use Classes\Request;

abstract class Model {

    private $_table_name, $_db;
    private $_select = "*";
    private $_pk = "id";
    private $_fields;
    private $_where = "";
    private $_prepare_values = "";
    private $_prepare_fields = "";
    private $_prepare_query;
    private $_insert_fields;
    private $_required;
    protected $errors;
    public $elements_on_page = false, $cur_page = 1, $elements, $pager_var_name = "page";

    public function __construct() {
        $request = new Request();
        ($this->cur_page = (int)$request->getFileds($this->pager_var_name)) ? true : $this->cur_page = 1;

        $this->_db = Db::getInstance();
        $this->_table_name = strtolower(str_replace("App\Models\\", "", get_class($this)));
    }

    public function setReqiredFileds(array $rqFields) {
        $this->_required = $rqFields;
        return $this;
    }

    public function getTableName() {
        return $this->table_name;
    }

    public function getErrors() {
        return $this->errors;
    }

    public function setTableName($table_name) {
        $this->_table_name = $table_name;
        return $this;
    }

    public function all() {
        $this->_db->query("SELECT " . $this->_select . " FROM `" . $this->_table_name . "`");
        return $this;
    }

    public function setPk($pk) {
        $this->_pk = $pk;
        return $this;
    }

    public function getById($id) {
        $this->_db->query("SELECT " . $this->_select . " FROM `" . $this->_table_name . "` WHERE " . $this->_pk . "='" . $id . "'");
        return $this;
    }

    public function select(array $select) {
        $this->_select = implode(",", $select);

        return $this;
    }

    public function getElemntsCount($condition = "") {
        if (!$this->elements) {
            $condition ? $condition = "WHERE " . $condition : false;
            $this->elements = Db::getInstance()->query("SELECT count(*) as C FROM `" . $this->_table_name . "` " . $condition)->fetch()[0]["C"];
        }
        return $this->elements;
    }

    public function prepare() {
        if (is_array($this->_insert_fields)) {
            foreach ($this->_insert_fields as $fName => $fValue) {
                if (!$this->_prepare_values) {
                    $this->_prepare_values = ":" . $fName;
                    $this->_prepare_fields = $fName;
                } else {
                    $this->_prepare_values .= ",:" . $fName;
                    $this->_prepare_fields .= "," . $fName;
                }
            }
        }
    }
   public function prepareUpadate() {
        if (is_array($this->_insert_fields)) {
            foreach ($this->_insert_fields as $fName => $fValue) {
                if (!$this->_prepare_fields) {
                    $this->_prepare_fields = $fName."=:".$fName;
                } else {
                    $this->_prepare_fields .= ",".$fName."=:".$fName;
                }
            }
        }
    }
    public function validatinReqire() {
        if ($this->_insert_fields && $this->_required) {

            foreach ($this->_insert_fields as $fName => $value) {
                if (empty(strip_tags(trim($value))) && in_array($fName, $this->_required)) {
                    $this->errors = true;
                    Msg::getInstance()->addError("<strong>Error!</strong> type required fields (*)", "required");
                }
            }
        }
        return $this->errors;
    }

    public function saveInserdData() {
        if (is_array($this->_insert_fields)) {
            $_SESSION["fields"] = $this->_insert_fields;
        }
        return $this;
    }

    public function getInsertData() {
        $fields = [];
        if (is_array($this->_insert_fields)) {
            $fields = $this->_insert_fields;
        } elseif (isset($_SESSION["fields"]) && is_array($_SESSION["fields"])) {
            $fields = $_SESSION["fields"];
            $this->clearInsertData();
        }
        return $fields;
    }
    public function update(array $fileds, $id){
        if ($this->_insert_fields = $fileds) {
            if ($this->validatinReqire()) {
                $this->saveInserdData();
                return $this;
            }
            $this->prepareUpadate();
           
            if ($this->_prepare_fields && $this->_table_name) {
                $this->_prepare_query = $this->_db->getPdo()->prepare( "UPDATE ".$this->_table_name." SET ".$this->_prepare_fields." where ".$this->_pk."='".$id."'");
            }
            $this->clearInsertData();
            return $this;
        }
    }
    public function insert(array $fileds) {

        if ($this->_insert_fields = $fileds) {

            if ($this->validatinReqire()) {
                $this->saveInserdData();
                return $this;
            }
            $this->prepare();
            if ($this->_prepare_fields && $this->_prepare_values && $this->_table_name) {
                $this->_prepare_query = $this->_db->getPdo()->prepare("INSERT INTO " . $this->_table_name . " (" . $this->_prepare_fields . ") VALUES (" . $this->_prepare_values . ")");
            }
        }
        
        return $this;
    }

    public function clearInsertData() {
        unset($_SESSION["fields"]);
    }

 
    public function delete($id) {
        return $this;
    }

    public function save() {
        if (get_class($this->_prepare_query) == "PDOStatement" && is_array($this->_insert_fields)) {
            return $this->_prepare_query->execute($this->_insert_fields);
        }
    }
    public function queryParam($param){
        $this->_db->query("SELECT " . $this->_select . " FROM `" . $this->_table_name."` ".$param);
        return $this;
    }
    public function where($where) {

        $this->_db->query("SELECT " . $this->_select . " FROM `" . $this->_table_name . "` WHERE " . $where);

        return $this;
    }

    public function get() {
        return $this->_db->fetch();
    }

}
