<?php

namespace app\core\db;

use app\core\Application;
use app\core\Model;

abstract class DbModel extends Model
{
    abstract public function tableName(): string;
    abstract public function attributes(): array;
    abstract public function primaryKey(): string;
    public string $lastInsertId;

    public function save(): bool
    {
        $tableName = $this->tableName();
        $attributes = $this->attributes();
        $params = array_map(fn($attr) => ":$attr", $attributes);
        $statement = self::prepare
            ("INSERT INTO $tableName (".implode(',',$attributes).") VALUES (".implode(',', $params).")");

       foreach ($attributes as $attribute){
           $statement->bindValue(":$attribute", $this->{$attribute});
       }

       $statement->execute();
       $this->lastInsertId = Application::$app->db->pdo->lastInsertId();

        return true;
    }

    public function updateColumn(string $columnName): bool
    {
        $tableName = $this->tableName();

        $pkName = $this->primaryKey();
        $pkValue = $this->{$this->primaryKey()};

        $updatedValue = $this->{$columnName};
        $statement = self::prepare("UPDATE $tableName SET $columnName ='$updatedValue' WHERE $pkName = $pkValue;");

        $statement->execute();

        return true;
    }

    public function findOne($where): ?DbModel
    {
        $tableName = static::tableName();
        $attributes = array_keys($where);
        $sql = implode(" AND ", array_map(fn($attr) => "$attr = :$attr",$attributes));

        $statement  = self::prepare("SELECT * FROM $tableName WHERE $sql");
        foreach ($where as $key => $item){
            $statement->bindValue(":$key", $item);
        }

        $statement->execute();
        $found = $statement->fetchObject(static::class);
        if ($found === false) { $found = null; }

        return $found;
    }

    public static function prepare($sql): object
    {
        return Application::$app->db->pdo->prepare($sql);
    }

    public function loadId(): void
    {
        $this->{$this->primaryKey()} = $this->lastInsertId;
    }

}