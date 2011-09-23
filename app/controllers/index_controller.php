<?php
class index_controller extends base_controller {
    public function index($param, $request_param) {
        $this->registry->view->lang = 'zh_tw';

        $this->registry->view->show('index', '瘋料理 - 首頁');
    }

    public function submit_post_xhr($param, $request_param) {
        $this->registry->view->layout = '';

        $model = new search_model;
        $this->registry->view->result = $model->search($request_param['name']);
        $this->registry->view->show('search_submit', '瘋料理 - 搜尋結果');
    }
}
?>
