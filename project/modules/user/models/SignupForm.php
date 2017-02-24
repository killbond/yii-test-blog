<?php

namespace app\modules\user\models;

use Yii;
use yii\base\Model;
use app\modules\user\models\User;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $confirm;

    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['username', 'email', 'password', 'confirm'], 'required'],
            [['username', 'email', 'password', 'confirm'], 'string'],
            ['email', 'email'],
            ['password', 'compare', 'compareAttribute' => 'confirm'],
        ];
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function signup()
    {
        var_dump(Yii::$app->security->generatePasswordHash('demo'));
        die();
        if ($this->validate())
        {
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            $user->generateEmailConfirmToken();

            if ($user->save())
            {
                return $user;
            }
        }

        return null;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}
