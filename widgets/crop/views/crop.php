<?php
/**
 * @var $widget \app\widgets\crop\Crop
 */

?>
<div id="crop-avatar">

    <!-- Current avatar -->
    <div class="avatar-view" title="Change the avatar">
        <img src="<?= $widget->noPhotoUrl; ?>" id="user-avatar" alt="Avatar">
    </div>

    <!-- Cropping modal -->
    <div class="modal fade" id="avatar-modal" aria-hidden="true" aria-labelledby="avatar-modal-label"
         role="dialog" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="avatar-form" action="<?= Yii::t('crop', $widget->uploadUrl); ?>"
                      enctype="multipart/form-data" method="post">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title" id="avatar-modal-label"><?= Yii::t('crop', $widget->modalLabel); ?></h4>
                    </div>
                    <div class="modal-body">
                        <div class="avatar-body">

                            <!-- Upload image and data -->
                            <div class="avatar-upload">
                                <input type="hidden" class="avatar-src" name="avatar_src">
                                <input type="hidden" class="avatar-data" name="avatar_data">
                                <div class="btn-group btn-group-justified" role="group" aria-label="...">
                                    <label class="btn btn-primary btn-file">
                                        <?= Yii::t('crop', $widget->inputLabel); ?>
                                        <input type="file" class="avatar-input" id="avatarInput" name="avatar_file"
                                               style="display: none;">
                                    </label>
                                </div>

                            </div>

                            <!-- Crop and preview -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="avatar-wrapper"></div>
                                </div>
                            </div>

                            <div class="row avatar-btns">
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary btn-block avatar-save">
                                        <?= Yii::t('crop', $widget->cropLabel); ?>
                                    </button>
                                </div>
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-block btn-default" data-dismiss="modal"
                                            data-target="#avatar-modal">
                                        Close
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- /.modal -->

    <!-- Loading state -->
    <div class="loading" aria-label="Loading" role="img" tabindex="-1"></div>
</div>
