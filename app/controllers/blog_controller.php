<?php
class blog_controller extends base_controller {
    public function index() {
        $this->registry->view->blog_heading = 'This is the blog index';
        $this->registry->view->show('blog_index', 'Blog');
    }

    public function index2_get($param, $request_param) {
        $this->post_get($param, $request_param);
    }

    public function post_get($param, $request_param) {
        $this->registry->view->blog_heading = 'Post a new blog';
        $this->registry->view->blog_content = 'Please add these contents';
        $this->registry->view->show('blog_post_get', 'Post a new blog');
    }

    public function item_get($param, $request_param) {
        $model = new blog_model();

        $this->registry->view->blog_heading = 'This is the blog heading';
        $this->registry->view->blog_item = $param[0];
        $this->registry->view->blog_content = $model->blog_item_get($param[0]);
        $this->registry->view->show('blog_item_get', 'Visit blog item');
    }

    public function item_post($param, $request_param) {
        $model = new blog_model();

        $this->registry->view->blog_heading = 'Add this';
        $this->registry->view->blog_content = $model->blog_item_post($request_param['content']);
        $this->registry->view->show('blog_item_post', 'Post blog item');
    }

    public function login_get($param, $request_param) {
        //$expire = time() + 86400;
        //$this->registry->cookie->setCookie('cookieName', 'cookie_value', 'username', $expire);

        $this->registry->cookie->setCookie('cookieName', 'cookie_value', 'username');
        $this->registry->cookie->setClassicCookie('classiccookieName', 'classic_cookie_value');
        $this->registry->view->secure_cookie = $this->registry->cookie->getCookieValue('cookieName');
        $this->registry->view->classic_cookie = $this->registry->cookie->getClassicCookieValue('classiccookieName');
        $this->registry->view->show('blog_login_get', 'Blog login');
    }

    public function html5_get() {
        $this->registry->view->layout = 'html5';
        $this->registry->view->blog_heading = 'This is the blog in HTML5';
        $this->registry->view->show('blog_index', 'Blog');
    }

    public function js_css_get() {
        $this->registry->view->show('blog_js_css_get', 'Js and Css');
    }

    public function i18n_get() {
        $this->registry->lang = 'zh_tw';
        $this->registry->view->welcome = 'Welcome';
        $this->registry->view->show('blog_i18n_get', 'i18n');
    }

    public function index_ipad() {
        $this->registry->view->blog_heading = 'You are iPad';
        $this->registry->view->show('blog_index', 'Blog');
    }

    public function index_mobile() {
        $this->registry->view->blog_heading = 'You are iPhone or Android';
        $this->registry->view->show('blog_index', 'Blog');
    }

    public function index_xhr() {
        $this->registry->view->blog_heading = 'You are XMLHttpRequest';
        $this->registry->view->show('blog_index', 'Blog');
    }
}
?>
