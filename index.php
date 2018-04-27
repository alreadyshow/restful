<?php
require __DIR__ . '/lib/User.php';
require __DIR__.'/lib/Article.php';
$pdo = require __DIR__.'/lib/db.php';

//$user = new User($pdo);
//print_r($user->register('admina','asd'));
//print_r($user->register('ccc','ccc'));
//print_r($user->login('ccc','ccc'));
$article=new Article($pdo);

//print_r($article->create('标题aa','内容','5'));
//print_r($article->view(1));
//print_r($article->edit(4,'ninini','dasjhdkjahsdkjsa',5));
//var_dump($article->delete(1,5));
print_r($article->articleList(5));