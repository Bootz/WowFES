<?php
class login_controller extends base_controller {
    public function index($param, $request_param) {
        $this->registry->view->show('login', '瘋料理 - 登入');
    }

    public function submit_post_xhr($param, $request_param) {
        $this->registry->view->layout = '';

        $username = isset($request_param['username']) ? $request_param['username'] : '';
        $password = isset($request_param['password']) ? $request_param['password'] : '';

        if (empty($username) || empty($password)) {
            return;
        }
        else {
            $model = new login_model();
            if ($model->login($username, $password)) {
                session_start();
                $_SESSION['username'] = $username;
                $this->registry->view->result = '登入成功';
            }
            else {
                $this->registry->view->result = '登入失敗';
            }
        }
        $this->registry->view->show('login_submit', '瘋料理 - 登入結果');
    }
}
?>
