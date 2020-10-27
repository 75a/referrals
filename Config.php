<?php
namespace app;

class Config {
    public static function getConfig(){
        return [
            'userClass' => \app\models\User::class,
            'reflinkURL' => "http://localhost:8080/r?code=",
            'db' => [
                'dsn' => $_ENV['DB_DSN'],
                'user' => $_ENV['DB_USER'],
                'password' => $_ENV['DB_PASSWORD'],
            ]
        ];
    }
}