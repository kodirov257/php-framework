<?php
/**
 * @var Framework\Template\PhpRenderer $this
 */
?>
<?php $this->extend('layout/default'); ?>

<?php $this->beginBlock('content'); ?>
    <div class="row">
        <div class="col-md-9">
            <?= $this->renderBlock('main') ?>
        </div>
        <div class="col-md-3">
            <?php if ($this->ensureBlock('sidebar')): ?>
                <div class="panel panel-default" style="width: 25rem">
                    <div class="panel-heading">Site</div>
                    <div class="panel-body">
                        Site navigation
                    </div>
                </div>
            <?php $this->endBlock(); endif; ?>
            <?= $this->renderBlock('sidebar'); ?>
        </div>
    </div>
<?php $this->endBlock(); ?>
