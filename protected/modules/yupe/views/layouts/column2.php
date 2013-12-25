<?php $this->beginContent($this->yupe->getBackendLayoutAlias("main")); ?>
    <div class="row-fluid">
        <div class="<?php echo $this->hideSidebar ? 'span12' : 'span9'; ?>">
            <?php
            if (count($this->breadcrumbs))
                $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
                         'homeLink' => CHtml::link(Yii::t('YupeModule.yupe', 'Home'), array('/yupe/backend/index')),
                         'links'    => $this->breadcrumbs,
                ));
            ?><!-- breadcrumbs -->
            <?php $this->widget('YFlashMessages');?>
            <div id="content">
                <?php echo $content; ?>
            </div>
            <!-- content -->
        </div>
        <div class="<?php echo $this->hideSidebar ? 'hide' : 'span3'; ?>" style="margin-top: 18px;">
            <?php if (count($this->menu)): ?>
                <div class="well" style="padding: 8px 0;">
                    <?php $this->widget(
                        'bootstrap.widgets.TbMenu', array(
                            'type' => 'list',
                            'items' => $this->yupe->getSubMenu($this->menu),
                        )
                    ); ?>
                </div>
            <?php endif; ?>
            <div class="well" style="padding: 8px;"><?php $this->widget('YModuleInfo'); ?></div>
        </div>
    </div>
<?php $this->endContent(); ?>