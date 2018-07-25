<?
namespace Classes;

trait Singleton {
    static private $instance = null;

    private function __construct() {} 
    private function __clone() {}  
    private function __wakeup() {}  
    /**
     * @return null|static new getInstance()
     */
    static public function getInstance() {
       
		if (!(self::$instance instanceof self)) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}