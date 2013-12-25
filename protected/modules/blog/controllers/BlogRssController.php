<?php

/**
 * BlogRssController контроллер для rss на публичной части сайта
 *
 * @author yupe team <team@yupe.ru>
 * @link http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.blog.controllers
 * @since 0.1
 *
 */

class BlogRssController extends yupe\components\controllers\FrontController
{
    public function actions()
    {
        if (!($limit = (int)$this->module->rssCount)) {
            throw new CHttpException(404);
        }

        $criteria = new CDbCriteria;
        $criteria->order = 'publish_date DESC';
        $criteria->params = array();
        $criteria->limit = $limit;

        $title = Yii::app()->getModule('yupe')->siteName;
        $description = Yii::app()->getModule('yupe')->siteDescription;

        $blogId = (int)Yii::app()->getRequest()->getQuery('blog');

        if (!empty($blogId)) {
            $blog = Blog::model()->cache(Yii::app()->getModule('yupe')->coreCacheTime)->published()->findByPk($blogId);
            if (null === $blog) {
                throw new CHttpException(404);
            }
            $title = $blog->name;
            $description = $blog->description;
            $criteria->addCondition('blog_id = :blog_id');
            $criteria->params[':blog_id'] = $blogId;
        }

        $categoryId = (int)Yii::app()->getRequest()->getQuery('category');

        if (!empty($categoryId)) {
            $category = Category::model()->cache(Yii::app()->getModule('yupe')->coreCacheTime)->published()->findByPk($categoryId);
            if (null === $category) {
                throw new CHttpException(404);
            }
            $title = $category->name;
            $description = $category->description;
            $criteria->addCondition('category_id = :category_id');
            $criteria->params[':category_id'] = $categoryId;
        }

        $tag = Yii::app()->getRequest()->getQuery('tag');

        if (!empty($tag)) {
            $data = Post::model()->with('createUser')->published()->public()->taggedWith($tag)->findAll();
        } else {
            $data = Post::model()->cache(Yii::app()->getModule('yupe')->coreCacheTime)->with('createUser')->published()->public(
            )->findAll($criteria);
        }

        return array(
            'feed' => array(
                'class' => 'application.modules.yupe.components.actions.YFeedAction',
                'data' => $data,
                'title' => $title,
                'description' => $description,
                'itemFields' => array(
                    'author_object' => 'createUser',
                    'author_nickname' => 'nick_name',
                    'content' => 'content',
                    'datetime' => 'create_date',
                    'link' => '/blog/post/show',
                    'linkParams' => array('slug' => 'slug'),
                    'title' => 'title',
                    'updated' => 'update_date',
                ),
            ),
        );
    }
}