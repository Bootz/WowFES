<?php
class logout_controller extends base_controller {
    public function index($param, $request_param) {
        session_start();
        session_unset();
        session_destroy();
        $this->registry->view->show('logout', '瘋料理 - 登出');
    }
}
?>
