<?php
class register_model {
    public function adduser($username, $password, $email) {

        if ($this->user_is_exist($username)) {
            return "使用者名稱已存在";
        }

        $current_date = date ('Y-m-d H:i:s');

        //$table = "login";
        //$data = array(
                        //'username'        => $username,
                        //'password'        => $password,
                        //'email'           => $email,
                        //'status'          => 'ENABLED',
                        //'createdBy'       => 'root',
                        //'createdTime'     => $current_date,
                        //'lastUpdatedBy'   => 'root',
                        //'lastUpdatedTime' => $current_date
                //);
        //return WowPDOManager::insert($table, $data);

        $orm = ORM::for_table('login')->create();
        $orm->username = $username;
        $orm->password = $password;
        $orm->email = $email;
        $orm->status = 'ENABLED';
        $orm->createdBy = 'root';
        $orm->createdTime = $current_date;
        $orm->lastUpdatedBy = 'root';
        $orm->lastUpdatedTime = $current_date;
        $orm->save();

        return TRUE;
    }

    public function user_is_exist($username) {
        //$table = "login";
        //$data = array(
                        //'username'        => $username,
                        //'status'          => 'ENABLED',
        //);
        //return count(WowPDOManager::select($table, '*', $data));

        $count = ORM::for_table('login')
            ->where_equal('username',$username)
            ->where_equal('status','ENABLED')->count();

        if ($count > 0) {
            return TRUE;
        }
        return FALSE;
    }
}
?>
