<?php $this->pageTitle = $blog->name; ?>
<?php $this->description = $blog->description; ?>

<?php
$mainAssets = Yii::app()->AssetManager->publish(
    Yii::app()->theme->basePath . "/web/"
);

Yii::app()->clientScript->registerCssFile($mainAssets . '/css/blog.css');
Yii::app()->clientScript->registerScriptFile($mainAssets . '/js/blog.js');

$this->breadcrumbs = array(
    Yii::t('BlogModule.blog', 'Blogs') => array('/blog/blog/index/'),
    $blog->name,
);
?>
<div class="row-fluid">
    <div class="blog-logo pull-left">
        <?php echo CHtml::image(
            $blog->getImageUrl(),$blog->name,
            array(
                'width'  => 109,
                'height' => 109
            )
        ); ?>
    </div>
    <div class="blog-description">
        <div class="blog-description-name">
            <?php echo CHtml::link($blog->name, array('/blog/post/blog/','slug' => $blog->slug)); ?>
            
            <?php echo CHtml::link(
                CHtml::image(
                    $mainAssets . "/images/rss.png",
                    Yii::t('BlogModule.blog', 'Subscribe for updates') . ' ' . $blog->name,
                    array(
                        'title' => Yii::t('BlogModule.blog', 'Subscribe for updates') . ' ' . $blog->name,
                        'class' => 'rss'
                    )
                ), array(
                    '/blog/blogRss/feed/', array(
                        'blog' => $blog->id
                    )
                )
            ); ?>
        </div>

        <div class="blog-description-info">
            <span class="blog-description-owner">
                <i class="icon-user"></i>
                <?php echo Yii::t('BlogModule.blog', 'Created'); ?>:
                <b>
                    <?php $this->widget(
                        'application.modules.user.widgets.UserPopupInfoWidget', array(
                            'model' => $blog->createUser
                        )
                    ); ?>
                </b>
            </span>

            <span class="blog-description-datetime">
                <i class="icon-calendar"></i>
                <?php echo Yii::app()->getDateFormatter()->formatDateTime($blog->create_date, "short", "short"); ?>
            </span>

            <span class="blog-description-posts">
                <i class="icon-pencil"></i>
                <?php echo CHtml::link($blog->postsCount, array('/blog/post/blog/','slug' => $blog->slug)); ?>
            </span>
        </div>

        <?php if (mb_strlen($blog->description) > 0) : ?>
        <div class="blog-description-text">
            <?php echo $blog->description; ?>
        </div>
        <?php endif; ?>
        
        <?php $this->widget('blog.widgets.MembersOfBlogWidget', array('blogId' => $blog->id)); ?>
    </div>
</div>

<?php $this->widget('blog.widgets.LastPostsOfBlogWidget', array('blogId' => $blog->id, 'limit' => 3)); ?>

<?php $this->widget('application.modules.blog.widgets.ShareWidget');?>
<br /><br />

<?php $this->widget('application.modules.comment.widgets.CommentsListWidget', array('model' => $blog, 'modelId' => $blog->id)); ?>

<h3><?php echo Yii::t('BlogModule.blog', 'Leave comment'); ?></h3>

<?php $this->widget('application.modules.comment.widgets.CommentFormWidget', array(
    'redirectTo' => Yii::app()->createUrl('/blog/blog/show/', array('slug' => $blog->slug)),
    'model' => $blog,
    'modelId' => $blog->id,
)); ?>