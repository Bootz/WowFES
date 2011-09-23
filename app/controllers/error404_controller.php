<?php
class error404_controller extends base_controller {
    public function index($param, $request_param) {
        $this->registry->view->show('error404', 'Oops!');
    }
}
?>
