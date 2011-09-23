<?php
class upload_controller extends base_controller {
    public function index($param, $request_param) {
        session_start();
        if (isset($_SESSION['username'])) {
            $this->registry->view->show('upload', '瘋料理 - 上傳');
            return;
        }
        $this->registry->view->show('index', '瘋料理 - 首頁');
    }
}
?>
