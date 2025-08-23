<?php 
namespace app\core;

abstract class DbModel extends Model {

abstract static public function tableName():string;

abstract public function attributes():array;

abstract static public function primaryKey():string;


    public function save(){
        $tableName = $this->tableName();
        $attributes = $this->attributes();
        $params = array_map(fn($attr) => ":$attr", $attributes);
        //array map with attributes
        $statement = self::prepare("INSERT INTO $tableName (".implode(',', $attributes).")
         VALUES (".implode(',', $params).")");

        foreach ($attributes as $attribute) {
            $statement->bindValue(":$attribute", $this->{$attribute});
        }

        $statement->execute();
        return true;
    }

    public static function findOne($where){ 
        // [email=> @example.com , name => 'name']
        $tableName = static::tableName();

        $attributes = array_keys($where);

        // output data raw select show it 

        $sql = implode("AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));

        $statement = self::prepare("SELECT * FROM $tableName WHERE $sql");
        foreach ($where as $key => $item) {
            
            $statement->bindValue(":$key", $item);
        }
        $statement->execute();
        $result = $statement->fetchObject(static::class);
        return $result ?: null;   // 👈 return null instead of false
    }

    public static function prepare($sql){
        return Application::$app->db->pdo->prepare($sql);
    }
}