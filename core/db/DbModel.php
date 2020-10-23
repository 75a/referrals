<?php


namespace app\core\db;


use app\core\Application;
use app\core\Model;

abstract class DbModel extends Model
{
    abstract public function tableName(): string;
    abstract public function attributes(): array;
    abstract public function primaryKey(): string;

    public function save(): void
    {
        $tableName = $this->tableName();
        $attributes = $this->attributes();
        $params = array_map(fn($attr) => ":$attr", $attributes);
        $statement = self::prepare("INSERT INTO $tableName (".implode(',',$attributes).")
        VALUES (".implode(',', $params).")");

       foreach ($attributes as $attribute){
           $statement->bindValue(":$attribute", $this->{$attribute});
       }
       $statement->execute();

    }

    public function findOne($where)
    {
        $tableName = static::tableName();
        $attributes = array_keys($where);
        $sql = implode(" AND ", array_map(fn($attr) => "$attr = :$attr",$attributes));

        $statement  = self::prepare("SELECT * FROM $tableName WHERE $sql");
        foreach ($where as $key => $item){
            $statement->bindValue(":$key", $item);
        }

        $statement->execute();
        return $statement->fetchObject(static::class);
    }

    public static function count($tableName, $where)
    {
        $attributes = array_keys($where);
        $sql = implode(" AND ", array_map(fn($attr) => "$attr = :$attr",$attributes));

        $statement  = self::prepare("SELECT COUNT(*) AS `count` FROM $tableName WHERE $sql");
        foreach ($where as $key => $item){
            $statement->bindValue(":$key", $item);
        }

        $statement->execute();

        return $statement->fetchColumn(0);
    }

    public static function prepare($sql): object
    {
        return Application::$app->db->pdo->prepare($sql);
    }



}