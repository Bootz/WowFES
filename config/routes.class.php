<?php
class routes {
    /**
     * Registry object
     */
    private $registry;

    /**
     * path variable
     */
    private $path;

    /**
     * args array
     */
    private $args = array();

    /**
     * file variable
     */
    public $file;

    /**
     * controller variable
     */
    public $controller;

    /**
     * action variable
     */
    public $action;

    /**
     * parameters variable
     */
    private $param;

    /**
     * request parameters variable
     */
    private $request_param;

    /**
     * request method
     */
    private $request_method;

    /**
     * Construct
     *
     * @param object $registry registry object
     * @return void
     */
    function __construct($registry) {
        $this->registry = $registry;
    }

    /**
     * Initial
     *
     * @param string $path
     * @return void
     */
    function init($path) {
        if (is_dir($path) == FALSE) {
            throw new Exception ('Invalid controller path: `' . $path . '`');
        }
        $this->path = $path;
    }

    /**
     * Get client information
     * @return string
     */
    private function get_client() {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            return '_xhr';
        }
        else {
            if (isset($_SERVER['HTTP_USER_AGENT'])) {
                // http://www.zytrax.com/tech/web/mobile_ids.html
                // http://www.galaxytabs.com/tag/user-agent/
                // http://detectmobilebrowsers.com/

                $_http_user_agent = $_SERVER['HTTP_USER_AGENT'];
                if (strpos($_http_user_agent,'iPad')) {
                    return '_ipad';
                }
                else if (strpos($_http_user_agent,'GT-')) {
                    return '_galaxytab';
                }
                else if (strpos($_http_user_agent,'iPhone')
                    || strpos($_http_user_agent,'iPod')
                    || strpos($_http_user_agent,'Android')
                    || strpos($_http_user_agent,'Bada')
                    || strpos($_http_user_agent,'BlackBerry')
                    || strpos($_http_user_agent,'HTC') // Opera in HTC
                    || strpos($_http_user_agent,'htc') // Opera in HTC
                    || strpos($_http_user_agent,'Opera Mobi')
                    || strpos($_http_user_agent,'Opera Mini')
                    || strpos($_http_user_agent,'Windows Mobile')
                    || strpos($_http_user_agent,'Windows Phone')
                    || strpos($_http_user_agent,'Symbian')
                    || strpos($_http_user_agent,'webOS')) {
                    return '_mobile';
                }
            }
        }
        return '';
    }

    /**
     * Validate request
     * @return array
     */
    private function safe_request() {

        WowSecFilter::cleanDefault();

        if (get_magic_quotes_gpc()) {
            $_REQUEST = WowSecFilter::stripslashes_deep($_REQUEST);
        }
        $_request_param = WowSecFilter::clean_deep($_REQUEST);

        if (isset($_POST['_method'])) {
            $_request_method = $_POST['_method'] . $this->get_client();
        }
        else {
            $_request_method = $_SERVER['REQUEST_METHOD'] . $this->get_client();
        }

        return array($_request_param, $_request_method);
    }

    /**
     * Initial controller
     *
     * @return void
     */
    public function run() {
        $this->map();

        if (!file_exists($this->file)) {
            $this->file = $this->path.'/error404_controller.php';
            $this->controller = 'error404';
        }

        // Initial controller
        require_once($this->file);

        $class = $this->controller . '_controller';
        $controller = new $class($this->registry);

        if (is_callable(array($controller, $this->action)) === FALSE) {
            //list($_action, $_request_method) = explode('_', $this->action);
            //if (is_callable(array($controller, $_action . '_' . $_request_method)) === FALSE) {
            //    if (is_callable(array($controller, $_action)) === FALSE) {
            //        $action = 'index';
            //    }
            //    else {
            //        $action = $_action;
            //    }
            //else {
            //    $action = $_action . '_' . $_request_method;
            //}
            $action = 'index';
        }
        else {
            $action = $this->action;
        }
        $controller->$action($this->param, $this->request_param);
    }

    /**
     * Map controller
     * @return void
     */
    private function map() {
        // Get route from URL
        $route = (empty($_GET['r'])) ? '' : $_GET['r'];
        list($this->request_param, $this->request_method) = $this->safe_request();

        if (empty($route)) {
            $route = 'index';
        }
        else {
            $parts = explode('/', $route);
            $this->controller = $parts[0];
            if(isset($parts[1])) {
                $this->action = $parts[1] . '_' . $this->request_method;
                if(isset($parts[2])) {
                    $this->param = array_slice($parts, 2);
                }
            }
        }

        if (empty($this->controller)) {
            $this->controller = 'index';
        }

        if (empty($this->action)) {
            $this->action = 'index' . '_' . $this->request_method;
        }

        $this->file = $this->path .'/'. $this->controller . '_controller.php';
    }
}
?>
