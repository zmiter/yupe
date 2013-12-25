<?php
    $this->breadcrumbs = array(      
        Yii::t('DictionaryModule.dictionary', 'Dictionaries') => array('/dictionary/dictionaryBackend/index'),
        Yii::t('DictionaryModule.dictionary', 'Create'),
    );

    $this->pageTitle = Yii::t('DictionaryModule.dictionary', 'Dictionaries - create');

    $this->menu = array(
        array('label' => Yii::t('DictionaryModule.dictionary', 'Dictionaries'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('DictionaryModule.dictionary', 'Dictionaries management'), 'url' => array('/dictionary/dictionaryBackend/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('DictionaryModule.dictionary', 'Dictionary crate'), 'url' => array('/dictionary/dictionaryBackend/create')),
        )),
        array('label' => Yii::t('DictionaryModule.dictionary', 'Items'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('DictionaryModule.dictionary', 'Items list'), 'url' => array('/dictionary/dictionaryDataBackend/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('DictionaryModule.dictionary', 'Create item'), 'url' => array('/dictionary/dictionaryDataBackend/create')),
        )),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('DictionaryModule.dictionary', 'Dictionaries'); ?>
        <small><?php echo Yii::t('DictionaryModule.dictionary', 'create'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>