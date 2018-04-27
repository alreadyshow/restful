<?php
/**
 * ErrorCode.php make in restful
 * Created by PhpStorm.
 * User: WQ
 * Date: 2018/04/27 0027
 * Time: 11:33
 */

class ErrorCode
{
    const USERNAME_EXIST             = 1;//用户名已存在
    const PASSWORD_EMPTY             = 2;//密码不能为空
    const USERNAME_EMPTY             = 3;//用户名不能为空
    const REGISTER_FAIL              = 4;//注册失败
    const USERNAME_OR_PASSWORD_ERROR = 5;//用户名或者密码错误
    const TITLE_EMPTY                = 6;//标题不能为空
    const CONTENT_EMPTY              = 7;//内容不能为空
    const ARTICLE_CREATE_FAIL        = 8;//文章创建失败
    const ARTICLEID_CAN_NOT_EMPTY    = 9;//文章id不能为空
    const ARTICLE_NOT_FOUND          = 10;//文章不存在
    const PERMISSION_DENIED          = 11;//无权限操作
    const ARTICLE_EDIT_FAIL=12;//文章编辑失败
    const ARTICLE_DELETE_FAIL=13;//文章删除失败
    const PAGE_SIZE_TOO_BIG=14;//分页最大为100
}