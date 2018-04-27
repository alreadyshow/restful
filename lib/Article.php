<?php
/**
 * Article.php make in restful
 * Created by PhpStorm.
 * User: WQ
 * Date: 2018/04/27 0027
 * Time: 10:25
 */
require_once __DIR__ . '/ErrorCode.php';
date_default_timezone_set('Etc/GMT-8');


class Article
{
    /**
     * 数据库连接句柄
     * @var
     */
    private $_db;

    /**
     * Article constructor.
     *
     * @param PDO $_db 数据库句柄
     */
    public function __construct ($_db)
    {
        $this->_db = $_db;
    }

    /**
     * 创建文章
     *
     * @param $title
     * @param $content
     * @param $userId
     *
     * @return array
     * @throws Exception
     */
    public function create ($title, $content, $userId)
    {
        $this->_isEmpty($title, $content);
        $sql = 'INSERT INTO `article` (`title`,`content`,`createdAt`,`user_id`) VALUES (:title,:content,:createdAt,:user_id)';
        $createdAt = date('Y-m-d H:i:s', time());

        $stmt = $this->_db->prepare($sql);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':createdAt', $createdAt);
        $stmt->bindParam(':user_id', $userId);
        if (!$stmt->execute()) {
            throw new Exception('文章创建失败', ErrorCode::ARTICLE_CREATE_FAIL);
        }
        return [
            'articleId' => $this->_db->lastInsertId(),
            'title'     => $title,
            'content'   => $content,
            'createdAt' => $createdAt,
            'userId'    => $userId,
        ];
    }

    /**
     * 编辑文章
     *
     * @param $artileId
     * @param $title
     * @param $content
     * @param $userId
     *
     * @return mixed
     * @throws Exception
     */
    public function edit ($artileId, $title, $content, $userId)
    {
        $article = $this->view($artileId);
        if ($userId !== $article['user_id']) {
            throw new Exception('您没有权限编辑该文章', ErrorCode::PERMISSION_DENIED);
        }
        $title = empty($title) ? $article['title'] : $title;
        $content = empty($content) ? $article['content'] : $content;
        if ($title === $article['title'] && $content === $article['content']) {
            return $article;
        }
        $sql = 'UPDATE `article` SET `title`=:title,`content`=:content WHERE `article_id`=:articleId';
        $stmt = $this->_db->prepare($sql);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':articleId', $artileId);
        if (!$stmt->execute()) {
            throw new Exception('文章修改失败', ErrorCode::ARTICLE_EDIT_FAIL);
        }
        return [
            'articleId' => $artileId,
            'title'     => $title,
            'content'   => $content,
            'createdAt' => $article['createdAt'],
        ];
    }

    /**
     * 删除文章
     *
     * @param $article
     * @param $userId
     */
    public function delete ($articleId, $userId)
    {
        $article = $this->view($articleId);
        if ($userId !== $article['user_id']) {
            throw new Exception('您没有权限删除该文章', ErrorCode::PERMISSION_DENIED);
        }
        $sql = 'DELETE FROM `article` WHERE `article_id`=:articleId AND `user_id`=:userId';
        $stmt = $this->_db->prepare($sql);
        $stmt->bindParam(':userId', $userId);
        $stmt->bindParam(':articleId', $articleId);
        if (false === $stmt->execute()) {
            throw new Exception('删除文章失败', ErrorCode::ARTICLE_DELETE_FAIL);
        }
        return true;
    }

    /**
     * 读取文章列表
     *
     * @param     $userId
     * @param int $page
     * @param int $size
     */
    public function articleList ($userId, $page = 1, $size = 10)
    {
        if ($size > 100) {
            throw new Exception('分页最大为100', ErrorCode::PAGE_SIZE_TOO_BIG);
        }

        $sql = 'SELECT * FROM `article` WHERE `user_id`=:userId LIMIT :limit,:offset';
        $stmt = $this->_db->prepare($sql);
        $limit = ($page - 1) * $size;
        $limit = $limit < 0 ? 0 : $limit;

        $stmt->bindParam(':userId', $userId);
        $stmt->bindParam(':limit', $limit);
        $stmt->bindParam(':offset', $size);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    /**
     * 检测标题和内容是否为空
     *
     * @param $title
     * @param $content
     *
     * @return bool
     * @throws Exception
     */
    public function _isEmpty ($title, $content)
    {
        $res = true;

        if (empty($title)) {
            throw new Exception('标题不能为空', ErrorCode::TITLE_EMPTY);
        }
        if (empty($content)) {
            throw new Exception('内容不能为空', ErrorCode::CONTENT_EMPTY);
        }
        return $res;
    }

    /**
     * 查看文章
     *
     * @param $articleId
     *
     * @return mixed
     * @throws Exception
     */
    public function view ($articleId)
    {
        if (empty($articleId)) {
            throw new Exception('文章ID不能为空', ErrorCode::ARTICLEID_CAN_NOT_EMPTY);
        }
        $sql = 'SELECT * FROM `article` WHERE `article_id`=:articleId';
        $stmt = $this->_db->prepare($sql);
        $stmt->bindParam(':articleId', $articleId);
        $stmt->execute();
        $article = $stmt->fetch(PDO::FETCH_ASSOC);
        if (empty($article)) {
            throw new Exception('文章不存在', ErrorCode::ARTICLE_NOT_FOUND);
        }
        return $article;
    }
}