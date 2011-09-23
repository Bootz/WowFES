<?php
class upload_next_controller extends base_controller {
    public function index($param, $request_param) {
        session_start();
        if (isset($_SESSION['username']) && $_SESSION['upload_image_url']) {
            $this->registry->view->show('upload_next', '瘋料理 - 上傳');
            return;
        }
        $this->registry->view->show('index', '瘋料理 - 首頁');
    }

    public function add_post_xhr($param, $request_param) {
        $this->registry->view->layout = '';

        session_start();
        $image = isset($_SESSION['upload_image_url']) ? 'http://' . __fqdn . $_SESSION['upload_image_url'] : '';
        $name = isset($request_param['name']) ? $request_param['name'] : '';
        $ingredient = isset($request_param['ingredient']) ? $request_param['ingredient'] : '';
        $step = isset($request_param['step']) ? $request_param['step'] : '';
        $tips = isset($request_param['tips']) ? $request_param['tips'] : '';
        $extra = isset($request_param['extra']) ? $request_param['extra'] : '';

        $this->registry->view->result = $ingredient;

        //if (empty($image) || empty($name) || empty($ingredient)) {
        if (empty($name) || empty($ingredient)) {
            $this->registry->view->result = '上傳失敗';
        }
        else {
            $model = new upload_model();
            $addrecipe = $model->addrecipe($image, $name, $ingredient, $step, $tips, $extra);
            if ($addrecipe) {
            	$this->registry->view->result = '上傳成功';
            }
            else {
                $this->registry->view->result = '上傳失敗';
                $this->registry->view->result = $addrecipe;
            }
        }

        unset($_SESSION['upload_image_url']);
        $this->registry->view->show('upload_add', '瘋料理 - 上傳結果');
    }
}
?>
