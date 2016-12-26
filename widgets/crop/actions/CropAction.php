<?php

namespace app\widgets\crop\actions;

use app\widgets\crop\Crop;
use Yii;
use yii\base\Action;
use yii\base\DynamicModel;
use yii\base\InvalidConfigException;
use yii\web\BadRequestHttpException;
use yii\web\Response;
use yii\web\UploadedFile;
use yii\imagine\Image;
use Imagine\Image\Box;

class CropAction extends Action
{
    public $path;
    public $url;
    public $uploadParam = 'avatar_file';
    public $maxSize = 2097152;
    public $extensions = 'jpeg, jpg, png';
    public $width = 200;
    public $height = 200;

    public $data;

    /**
     * @inheritdoc
     */
    public function init()
    {
        Crop::registerTranslations();
        if ($this->url === null) {
            throw new InvalidConfigException('Missing attribute url');
        }
        $this->url = rtrim($this->url, '/') . '/';

        if ($this->path === null) {
            throw new InvalidConfigException('Missing attribute path');
        }
        $this->path = rtrim(Yii::getAlias($this->path), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        if (!Yii::$app->request->isPost) {
            throw new BadRequestHttpException(Yii::t('crop', 'Allowed only POST-request'));
        }

        $file = UploadedFile::getInstanceByName($this->uploadParam);
        $model = new DynamicModel(['file' => $file]);
        $this->ajaxValidate($model);
        Yii::$app->response->format = Response::FORMAT_JSON;

        if ($model->hasErrors()) {
            return ['message' => $model->getFirstError($this->uploadParam)];
        }

        $model->file->name = uniqid() . '.' . $model->file->extension;
        $request = Yii::$app->request;

        $this->setData($request->post('avatar_data'));

        $boxWidth = isset($this->data->width) ? $this->data->width : $this->width;
        $boxHeight = isset($this->data->height) ? $this->data->height : $this->height;

        $startX = ($this->data->x > 0) ? $this->data->x : 0;
        $startY = ($this->data->y > 0) ? $this->data->y : 0;
        $height = ($this->data->x < 0) ? $this->data->height + $this->data->x : $this->data->height;
        $width = ($this->data->x < 0) ? $this->data->width + $this->data->y : $this->data->width;

        $image = Image::crop(
            $file->tempName . $request->post('filename'),
            intval($width),
            intval($height),
            [$startX, $startY]
        )->resize(new Box($boxWidth, $boxHeight));

        if ($image->save($this->path . $model->file->name)) {
            return ['result' => $this->url . $model->file->name];
        }
        return ['message' => Yii::t('crop', 'Error can\'t upload file')];
    }

    /**
     * Set post data
     *
     * @param $data
     */
    private function setData($data)
    {
        if (!empty($data)) {
            $this->data = json_decode(stripslashes($data));
        }
    }

    /**
     * @param $model DynamicModel
     */
    protected function ajaxValidate($model)
    {
        $model->addRule('file', 'image', [
            'maxSize' => $this->maxSize,
            'tooBig' => Yii::t(
                'crop',
                'Exceeded the allowable size of the file ({size} Mb)',
                ['size' => $this->maxSize / (1024 * 1024)]
            ),
            'extensions' => explode(', ', $this->extensions),
            'wrongExtension' => Yii::t(
                'crop',
                'Enable only the following file formats: {formats}',
                ['formats' => $this->extensions]
            ),
        ])->validate();
    }
}
