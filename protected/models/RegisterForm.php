<?php

class RegisterForm extends CFormModel
{
    public $name;
    public $login;
    public $password;
    public $password2;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules()
    {
        return array(
            array('login, password, password2', 'required'),
            array('password2', 'compare'),
            array('name', 'safe'),
        );
    }


    /**
     * Authenticates the password.
     * This is the 'authenticate' validator as declared in rules().
     */
    public function compare($attribute,$params)
    {
        if(!$this->hasErrors())
        {
            if($this->password!==$this->password2){
                $this->password='';
                $this->password2='';
                $this->addError('password2','Passwords did not match.');
            }

        }
    }

    /**
     * Logs in the user using the given username and password in the model.
     * @return boolean whether login is successful
     */
    public function register()
    {
        if(User::model()->findAllByAttributes(array('login'=>$this->login))){
            $this->addError('login','Login already exist.');
            $this->password='';
            $this->password2='';
            return false;
        }
        $user=new User();
        $user['name']=$this->name;
        $user['login']=$this->login;
        $user['password']=$user->hashPassword($this->password);
        $user['role']='user';
        return $user->save();
    }

    public function attributeLabels()
    {
        return array(
            'name' => 'Name',
            'login' => 'Login',
            'password' => 'Password',
            'password2' => 'Password repeat',

        );
    }
}
