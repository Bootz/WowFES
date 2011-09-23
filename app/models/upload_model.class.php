<?php
class upload_model {
    public function getRecipe($name) {
        if ($this->recipe_is_exist($name)) {
            //$table = "recipe";
            //$data = array(
                            //'name' => $name,
                    //);
            //return WowPDOManager::select($table, '*', $data);

            return ORM::for_table('recipe')
                ->where_equal('name',$name)->find_many();
        }
    }

    public function addrecipe($image, $name, $ingredient, $step, $tips, $extra) {

        @session_start();
        $username = isset($_SESSION['username']) ? $_SESSION['username'] : '';

        if ($this->recipe_is_exist($name)) {
            return "食譜名稱已存在";
        }

        $current_date = date ('Y-m-d H:i:s');

        //$table = "recipe";
        //$data = array(
                        //'image'           => $image,
                        //'name'            => $name,
                        //'ingredient'      => $ingredient,
                        //'step'            => $step,
                        //'tips'            => $tips,
                        //'extra'           => $extra,
                        //'createdBy'       => $username,
                        //'createdTime'     => $current_date,
                        //'lastUpdatedBy'   => $username,
                        //'lastUpdatedTime' => $current_date
                //);
        //if (WowPDOManager::insert($table, $data) === 1) {
            //return TRUE;
        //}
        //return FALSE;

        $orm = ORM::for_table('recipe')->create();
        $orm->image = $image;
        $orm->name = $name;
        $orm->ingredient = $ingredient;
        $orm->step = $step;
        $orm->tips = $tips;
        $orm->extra = $extra;
        $orm->createdBy = $username;
        $orm->createdTime = $current_date;
        $orm->lastUpdatedBy = $username;
        $orm->lastUpdatedTime = $current_date;
        $orm->save();

        return TRUE;
    }

    public function recipe_is_exist($name) {
        //$table = "recipe";
        //$data = array(
                        //'name'        => $name
        //);
        //if (count(WowPDOManager::select($table, '*', $data)) > 0) {
            //return TRUE;
        //}
        //return FALSE;

        $count = ORM::for_table('recipe')
            ->where_equal('name',$name)->count();

        if ($count > 0) {
            return TRUE;
        }
        return FALSE;
    }
}
?>
