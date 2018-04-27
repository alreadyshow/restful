<?php
/**
 * User.php make in restful
 * Created by PhpStorm.
 * User: WQ
 * Date: 2018/04/27 0027
 * Time: 10:25
 */

require_once __DIR__ . '/ErrorCode.php';

class User
{

    /**
     * 数据库连接句柄
     * @var
     */
    private $_db;

    /**
     * 构造方法
     * user constructor.
     *
     * @param PDO $_db PDO连接句柄
     */
    public function __construct ($_db)
    {
        $this->_db = $_db;
    }

    /**
     * 用户登录
     *
     * @param $username
     * @param $password
     *
     * @return mixed
     * @throws Exception
     */
    public function login ($username, $password)
    {
        $this->_isEmpty($username, $password);
        $sql = 'SELECT * FROM `user` where `username`=:username and `password`=:password';
        $password = $this->_md5($password);

        $stmt = $this->_db->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if (empty($user)) {
            throw new Exception('用户名或密码错误', ErrorCode::USERNAME_OR_PASSWORD_ERROR);
        }
        unset($user['password']);

        return $user;
    }

    /**
     * 用户注册
     *
     * @param $username
     * @param $password
     *
     * @return array
     * @throws Exception
     */
    public function register ($username, $password)
    {

        $this->_isEmpty($username, $password);

        if ($this->_isUsernameExist($username)) {
            throw new Exception('用户名已存在', ErrorCode::USERNAME_EXIST);
        }
        //写入数据库

        $sql = 'INSERT INTO `user` (`username`,`password`,`createdAt`) VALUES (:username,:password,:createdAt)';
        $createdAt = date('Y-m-d H:i:s', time());
        $password = $this->_md5($password);
        $stmt = $this->_db->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':createdAt', $createdAt);
        if (!$stmt->execute()) {
            throw new Exception('注册失败', ErrorCode::REGISTER_FAIL);
        }
        return [
            'user_id'   => $this->_db->lastInsertId(),
            'username'  => $username,
            'createdAt' => $createdAt,
        ];
        unset($password);

    }

    /**
     * MD5加密
     *
     * @param        $password
     * @param string $key
     *
     * @return string
     */
    public function _md5 ($password, $key = 'restful')
    {
        return md5($password . $key);
    }

    /**
     * 判断用户是否存在
     *
     * @param $username
     *
     * @return bool
     */
    public function _isUsernameExist ($username)
    {
        $sql = 'SELECT * FROM `user` WHERE `username`=:username';
        $stmt = $this->_db->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return !empty($result);
    }

    /**
     * 检测用户名、密码是否为空
     *
     * @param $username
     * @param $password
     *
     * @return bool
     * @throws Exception
     */
    public function _isEmpty ($username, $password)
    {
        $res = true;

        if (empty($username)) {
            throw new Exception('用户名不能为空', ErrorCode::USERNAME_EMPTY);
        }
        if (empty($password)) {
            throw new Exception('密码不能为空', ErrorCode::PASSWORD_EMPTY);
        }
        return $res;
    }
}