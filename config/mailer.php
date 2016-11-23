<?php
return [
    'class' => 'yii\swiftmailer\Mailer',
    'transport' => [
        'class' => 'Swift_SmtpTransport',
        'host' => 'smtp.gmail.com',
        'username' => 'goodeveningproj@gmail.com',
        'password' => 'good@evening',
        'port' => '587',
        'encryption' => 'tls',
    ],
];
