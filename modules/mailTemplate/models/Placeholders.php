<?php
namespace app\modules\mailTemplate\models;

use yii\base\Model;

class Placeholders extends Model
{
    public $user = '';
    public $data= '';
    public $link = '';
    public $password = '';

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user', 'data', 'link', 'password'], 'string'],
            ['link', 'url'],
        ];
    }
}
