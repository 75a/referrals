<?php

namespace app\core\db;

use app\core\Application;
use app\core\Model;
use DateTime;
use PDO;

class DbManager
{
    public static function add(Model $modelObject): int
    {
        $tableName = $modelObject::tableName();
        $attributes = $modelObject::attributes();

        $params = array_map(fn($attr) => ":$attr", $attributes);
        $statement = self::prepare
            ("INSERT INTO $tableName (".implode(',',$attributes).") VALUES (".implode(',', $params).")");

        foreach ($attributes as $attribute) {
            $statement->bindValue(":$attribute", $modelObject->{$attribute});
        }

        $statement->execute();
        return Application::$app->db->pdo->lastInsertId();
    }

    public static function findOne($modelClass, array $where)
    {
        $tableName = $modelClass::tableName();
        $attributes = array_keys($where);

        $sql = implode(" AND ", array_map(fn($attr) => "$attr = :$attr",$attributes));
        $statement  = self::prepare("SELECT * FROM $tableName WHERE $sql");
        foreach ($where as $key => $item){
            $statement->bindValue(":$key", $item);
        }

        $statement->execute();
        return $statement->fetchObject($modelClass);
    }

    public static function update (Model $modelObject)
    {
        $tableName = $modelObject::tableName();
        $attributes = $modelObject::attributes();
        $pkName = $modelObject::primaryKey();
        $pkValue = $modelObject->{$modelObject::primaryKey()};

        $params = array_map(fn($attr) => ":$attr", $attributes);
        $output = implode(', ', array_map(
            function ($v, $k) {
                return sprintf("%s = %s", $k, $v);
            },
            $params,
            $attributes
        ));
        $statement = self::prepare("UPDATE $tableName SET $output WHERE $pkName = $pkValue;");

        foreach ($attributes as $attribute) {
            $statement->bindValue(":$attribute", $modelObject->{$attribute});
        }
        $statement->execute();
        return true;
    }

    public static function prepare($sql): object
    {
        return Application::$app->db->pdo->prepare($sql);
    }
}