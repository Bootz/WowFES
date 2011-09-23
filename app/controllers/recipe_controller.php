<?php
class recipe_controller extends base_controller {
    public function index($param, $request_param) {
        $model = new recipe_model;
        $this->registry->view->result = $model->get($param[0]);
        $this->registry->view->show('recipe', '瘋料理 - 食譜');
    }
}
?>
