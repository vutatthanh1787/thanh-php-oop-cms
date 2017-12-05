<?php
class User {
    private $_db,
            $_data,
            $_sessionName,
            $_cookieName,
            $_isLoggedIn;

    /**
     * User constructor.
     * @param null $user
     */
    public function __construct($user = null) {
        $this->_db = DB::getInstance();


        $this->_sessionName = Config::get('session/session_name');
        $this->_cookieName = Config::get('remember/cookie_name');

        if(!$user){
            if(Session::exists($this->_sessionName)){
                $user = Session::get($this->_sessionName);
                if($this->find($user)){
                    $this->_isLoggedIn = true;
                } else {
                    // process logout
                }

            }
        } else {
            $this->find($user);
        }
    }

    /**
     * @param array $fields
     * @param null $id
     * @throws Exception
     */
    public function update($fields = array(), $id=null){

        if(!$id && $this->isLoggedIn()){
            $id = $this->data()->id;
        }
        if(!$this->_db->update('tbl_users', $id, $fields)){
            throw new Exception('Có vấn đề xảy ra trong quá trình cập nhật!');
        }
    }

    /**
     * @param $password
     * @param null $id
     * @throws Exception
     */
    public function change_password($password, $id = null){
        if(!$id && $this->isLoggedIn()){
            $id = $this->data()->id;
        }
        if(!$this->_db->update('tbl_users', $id, $fields)){
            throw new Exception('Có vấn đề xảy ra trong quá trình thay đổi mật khẩu!');
        }
    }

    /**
     * @param array $fields
     * @throws Exception
     */
    public function create($fields=array()){
        if (!$this->_db->insert('tbl_users', $fields)){
            throw new Exception('Có vấn đề xảy ra trong quá trình tạo tài khoản!');
        }
    }

    /**
     * @param null $user
     * @return bool
     */
    public function find($user = null){
        if($user){
            $field = (is_numeric($user)) ? 'id' : 'user_name';
            $data = $this ->_db->get('tbl_users', array($field, "=", $user));

            if($data->count()){
                $this->_data = $data->first();
                return true;
            }
        }
        return false;
    }

    /**
     * @param $key
     * @return bool
     */
    public function hasPermission($key) {
        $group = $this->_db->get('tbl_groups',array('id','=',$this->data()->group_id));
//        print_r($group->first());
        if ($group->count()){
            $permissions = json_decode($group->first()->group_permissions,true);

//            print_r($permissions['admin']);
//            die();

            if($permissions[$key] == true){
                return true;
            }
        }
        return false;
    }

    /**
     * @param null $username
     * @param null $password
     * @param bool $remember
     * @return bool
     */
    public function login($username = null, $password = null, $remember = false){
        $user = $this->find($username);
        if(!$username && !$password && $this->exists()){
            // log user in
            Session::put($this->_sessionName, $this->data()->id);
        } else {
            //print_r($this->_data);
            if ($user){
                if($this->data()->user_password === md5($password)){
                    Session::put($this->_sessionName,$this->data()->id);
                    return true;
                    //echo 'OK!';
                }
            }
            return false;
        }
    }

    /**
     * @return bool
     */
    public function exists(){
        return (!empty($this->_data)) ? true : false;
    }

    /**
     *
     */
    public function logout(){

        $this->_db->delete('users_session',array('user_id','=',$this->data()->id));
        Session::delete($this->_sessionName);
        //Cookie::delete($this->_cookieName);
    }

    /**
     * @return mixed
     */
    public function data(){
        return $this->_data;
    }

    /**
     * @return bool
     */
    public function isLoggedIn(){
        return $this->_isLoggedIn;
    }
}