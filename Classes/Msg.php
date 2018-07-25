<?

namespace Classes;

class Msg {

    use Singleton;

    public function addSuccess($msg) {
        $_SESSION["succes"][] = $msg;
        return $this;
    }

    public function getSuccess() {
        if (isset($_SESSION["succes"])) {
            $msg = $_SESSION["succes"];
            unset($_SESSION["succes"]);
            return $msg;
        }
    }
  
    public function addError($msg,$type=false) {
        !empty($type) ? $_SESSION["error"][$type] = $msg : $_SESSION["error"][] = $msg;
   
        return $this;
    }

    public function getError() {
        if (isset($_SESSION["error"])) {
            $msg = $_SESSION["error"];
            unset($_SESSION["error"]);
            return $msg;
        }
    }

}
