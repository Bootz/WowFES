<?php
class index_controller extends base_controller {
    public function index() {
        $this->registry->view->welcome = 'Welcome';
        $this->registry->view->show('index');
    }
}
?>
