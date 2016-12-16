<?php

namespace app\modules\user\actions;

use Yii;
use yii\base\DynamicModel;
use yii\web\BadRequestHttpException;
use yii\web\Response;
use yii\web\UploadedFile;
use yii\imagine\Image;
use Imagine\Image\Box;

class UploadAction extends \budyaga\cropper\actions\UploadAction
{
    /**
     * @inheritdoc
     */
    public function run()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!Yii::$app->request->isPost) {
            throw new BadRequestHttpException(Yii::t('cropper', 'ONLY_POST_REQUEST'));
        }

        $model = new DynamicModel(compact($this->uploadParam));
        $this->ajaxValidate($model);

        if ($model->hasErrors()) {
            return ['error' => $model->getFirstError($this->uploadParam)];
        }

        $model->{$this->uploadParam}->name = uniqid() . '.' . $model->{$this->uploadParam}->extension;
        $request = Yii::$app->request;

        $width = $request->post('width', $this->width);
        $height = $request->post('height', $this->height);

        if ((0 == $request->post('w')) || (0 == $request->post('h'))){
            return ['error' => Yii::t('cropper', 'ERROR_CAN_NOT_UPLOAD_FILE')];
        }

        $file = UploadedFile::getInstanceByName($this->uploadParam);
        $image = Image::crop(
            $file->tempName . $request->post('filename'),
            intval($request->post('w')),
            intval($request->post('h')),
            [$request->post('x'), $request->post('y')]
        )->resize(
            new Box($width, $height)
        );

        if ($image->save($this->path . $model->{$this->uploadParam}->name)) {
            return ['filelink' => $this->url . $model->{$this->uploadParam}->name];
        }
        return ['error' => Yii::t('cropper', 'ERROR_CAN_NOT_UPLOAD_FILE')];
    }

    /**
     * @param $model DynamicModel
     * @return mixed
     */
    protected function ajaxValidate($model)
    {
        $model->addRule($this->uploadParam, 'image', [
            'maxSize' => $this->maxSize,
            'tooBig' => Yii::t('cropper', 'TOO_BIG_ERROR', ['size' => $this->maxSize / (1024 * 1024)]),
            'extensions' => explode(', ', $this->extensions),
            'wrongExtension' => Yii::t('cropper', 'EXTENSION_ERROR', ['formats' => $this->extensions]),
        ])->validate();
        return $model;
    }
}