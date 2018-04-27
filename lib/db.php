<?php
/**
 * Copyright (c) 2018. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

/**
 *
 * 用来连接数据库并返回数据库连接句柄
 *
 * db.php make in restful
 * Created by PhpStorm.
 * User: WQ
 * Date: 2018/04/27 0027
 * Time: 10:25
 */

$pdo = new PDO('mysql:host=localhost;dbname=mydb','root','root');
$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
return $pdo;
