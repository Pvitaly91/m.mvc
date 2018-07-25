<?

namespace Classes;

use PDO;
class Db {

    use \Classes\Singleton;

    private $_host = 'localhost';
    private $_db_name = 'mvc';//mvctaskman
    private $_user = 'root';//mvctaskman
    private $_pass = ''; //da2_sd4#Gflsf taskman@mvctaskman.zzz.com.ua
    private $_charset = 'utf8';
    private $_result;
    private $_db;
    private function __construct() {


        $dsn = "mysql:host=".$this->_host.";dbname=".$this->_db_name.";charset=".$this->_charset;
        $opt = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        
        $this->_db = new PDO($dsn, $this->_user, $this->_pass, $opt);
       
    }
  
    
    public function getPdo(){
        return $this->_db;
    }
    public function query($query) {
        $this->result = $this->_db->query($query);
        return $this;
    }
    public function fetch(){
        return $this->result->fetchAll();
    }
}
