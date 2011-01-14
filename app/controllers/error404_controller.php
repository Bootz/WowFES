<?php
class error404_controller extends base_controller {
    public function index() {
        $this->registry->view->show('error404', 'Oops!');
    }
}
?>
