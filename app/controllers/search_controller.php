<?php
class search_controller extends base_controller {
    public function index($param, $request_param) {
        $this->registry->view->show('search', '瘋料理 - 搜尋');
    }

    public function submit_post_xhr($param, $request_param) {
        $this->registry->view->layout = '';

        $model = new search_model;
        $this->registry->view->result = $model->search($request_param['name']);
        $this->registry->view->show('search_submit', '瘋料理 - 搜尋結果');
    }
}
?>
