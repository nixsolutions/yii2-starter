<?php

use app\tests\functional\BaseFunctionalCest;
use yii\helpers\Url;

class CropAvatarCest extends BaseFunctionalCest
{
    /**
     * @before loginAsAdmin
     */
    public function changeAvatar(FunctionalTester $I)
    {
        $I->amOnPage(Url::toRoute('/user/default/update?id=1'));
        $I->seeResponseCodeIs(200);
        $I->click(['class' => 'avatar-view']);
        $I->see('Set avatar', 'h4');
        $I->click(['class' => 'btn-file']);
        $token = $I->grabMultiple("meta[name='csrf-token']", 'content');
        $I->setCookie('_csrf', $token[0]);
        $I->sendPost(
            '/user/auth/upload-avatar',
            [
                '_csrf' => $token[0],
                'avatar_src' => '',
                'avatar_data' => '{"x":88.2199450549451,"y":36.12460028092938,"height":615.1200000000001,"width":615.1200000000001,"rotate":0}',
            ],
            [
                'avatar_file' => codecept_data_dir('avatarka.jpg'),
            ]
        );
        $I->dontSeeResponseContains('message');
        $I->seeResponseJsonMatchesJsonPath('$.result');
    }
}
