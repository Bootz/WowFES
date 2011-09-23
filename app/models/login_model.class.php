<?php
class login_model {
    public function login($username, $password) {
        //$table = "login";
        //$data = array(
            //'username'        => $username,
            //'password'        => $password,
            //'status'          => 'ENABLED',
        //);
        //return WowPDOManager::select($table, '*', $data);

        return ORM::for_table('login')
            ->where_equal('username',$username)
            ->where_equal('password',$password)
            ->where_equal('status','ENABLED')->find_one();
    }
}
?>
