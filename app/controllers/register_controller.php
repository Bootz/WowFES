<?php
class register_controller extends base_controller {
    public function index($param, $request_param) {
        $this->registry->view->show('register', '瘋料理 - 註冊');
    }

    public function add_post_xhr($param, $request_param) {
        $this->registry->view->layout = '';

        $username = isset($request_param['username']) ? $request_param['username'] : '';
        $password = isset($request_param['password']) ? $request_param['password'] : '';
        $email = isset($request_param['email']) ? $request_param['email'] : '';

        if (empty($username) || empty($password) || empty($email)) {
            $this->registry->view->result = '註冊失敗';
        }
        else {
            $model = new register_model();
            $this->registry->view->result = $model->adduser($username, $password, $email);
        }

        $this->registry->view->show('register_add', '瘋料理 - 註冊結果');
    }
}
?>
