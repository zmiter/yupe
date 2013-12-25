<?php $this->pageTitle = Yii::t('FeedbackModule.feedback', 'FAQ'); ?>

<?php
    $this->breadcrumbs = array(
        Yii::t('FeedbackModule.feedback', 'Contacts') => array('/feedback/contact/index'),
        Yii::t('FeedbackModule.feedback', 'FAQ'),
    );
?>

<h1>
    <?php echo Yii::t('FeedbackModule.feedback', 'FAQ')?>
    <?php $this->widget(
        'bootstrap.widgets.TbButton',
        array(
            'htmlOptions' => array(
                'class' => 'btn btn-info'
            ),
            'buttonType' => 'link',
            'label' => Yii::t('FeedbackModule.feedback', 'Add question ?'),
            'url' => Yii::app()->createUrl('/feedback/contact/index/'),
        )
    ); ?>
</h1>


<?php $this->widget('bootstrap.widgets.TbListView', array(
                                                  'dataProvider' => $dataProvider,
                                                  'itemView' => '_view',
                                             )); ?>