<?php 

namespace app\core;

abstract class Model {

    public const RULE_REQUIRED = 'required';
    public const RULE_EMAIL    = 'email';
    public const RULE_MIN      = 'min';
    public const RULE_MAX      = 'max';
    public const RULE_MATCH    = 'match';
    public const RULE_UNIQUE   = 'unique';

    public array $errors = [];

    public function loadData($data){
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }
    // labels error messages representation -Add
    public function labels():array{
        return [];
    }
    // get label for specific attribute -Add
    public function getLabel($att): string {
        return $this->labels()[$att] ?? ucfirst($att);
    }

    abstract public function rules(): array;

    public function validate(){
        foreach ($this->rules() as $att => $rules) {
            $value = $this->{$att};
            foreach ($rules as $rule) {
                $ruleName = is_string($rule) ? $rule : $rule[0];

                if ($ruleName === self::RULE_REQUIRED && !$value) {
                    $this->addError($att, self::RULE_REQUIRED);
                }

                if ($ruleName === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addError($att, self::RULE_EMAIL);
                }

                if ($ruleName === self::RULE_MIN && strlen($value) < $rule['min']) {
                    $this->addError($att, self::RULE_MIN, ['min' => $rule['min']]);
                }

                if ($ruleName === self::RULE_MAX && strlen($value) > $rule['max']) {
                    $this->addError($att, self::RULE_MAX, ['max' => $rule['max']]);
                }

                if ($ruleName === self::RULE_MATCH && $value !== $this->{$rule['match']}) {
                    $this->addError($att, self::RULE_MATCH, ['match' => $rule['match']]);
                }
                if ($ruleName === self::RULE_UNIQUE){
                    $className = $rule['class'];
                    $uniqatt = $rule['attribute'] ?? $att;
                    $tableName = $className::tableName();
                    $statement =  Application::$app->db->prepare("SELECT * FROM $tableName WHERE $uniqatt = :$uniqatt");
                    $statement->bindValue(":$uniqatt", $value);
                    $statement->execute();
                    $record = $statement->fetchObject();
                    if ($record) {
                        $this->addError($att, self::RULE_UNIQUE, ['field' => $att]);
                    }

                }
            }
        }
        return empty($this->errors);
    }

    public function addError(string $att, string $rule, $params = []){
        $message = $this->errorMessages()[$rule] ?? '';

        // Always replace attribute name
        // $message = str_replace('{{ att }}', $att, $message);

        // Always replace attribute name  but with labels
        $message = str_replace('{{ att }}', $this->getLabel($att), $message);

        // Replace any extra params (min, max, match, etc.)
        foreach ($params as $key => $value) {
            $message = str_replace("{{ $key }}", $value, $message);
        }

        $this->errors[$att][] = $message;
    }
    // error messages representation but with labels in the User.php
    public function errorMessages(){
        return [
            self::RULE_REQUIRED => '{{ att }} is required',
            self::RULE_EMAIL    => '{{ att }} must be a valid email address',
            self::RULE_MIN      => '{{ att }} must be at least {{ min }} characters long',
            self::RULE_MAX      => '{{ att }} must not exceed {{ max }} characters',
            self::RULE_MATCH    => '{{ att }} must match {{ match }}',
            self::RULE_UNIQUE   => '{{ att }} is already taken',
        ];
    }
public function hasError($att) {
    return $this->errors[$att] ?? false;
}

public function getFirstError($att) {
    return $this->errors[$att][0] ?? false;
}

}


// <?php  FACTORED VERSION

// namespace app\core;

// abstract class Model {

//     public const RULE_REQUIRED = 'required';
//     public const RULE_EMAIL    = 'email';
//     public const RULE_MIN      = 'min';
//     public const RULE_MAX      = 'max';
//     public const RULE_MATCH    = 'match';
//     public const RULE_UNIQUE   = 'unique';

//     public array $errors = [];

//     public function loadData($data){
//         foreach ($data as $key => $value) {
//             if (property_exists($this, $key)) {
//                 $this->{$key} = $value;
//             }
//         }
//     }

//     // Labels for attributes
//     public function labels(): array {
//         return [];
//     }

//     public function getLabel($att): string {
//         return $this->labels()[$att] ?? ucfirst($att);
//     }

//     abstract public function rules(): array;

//     // ----------------- FACTORED VALIDATION -----------------
//     public function validate() {
//         foreach ($this->rules() as $att => $rules) {
//             $value = $this->{$att};

//             foreach ($rules as $rule) {
//                 $ruleName = is_string($rule) ? $rule : $rule[0];
//                 $this->dispatchRule($att, $value, $ruleName, $rule);
//             }
//         }
//         return empty($this->errors);
//     }

//     private function dispatchRule($att, $value, $ruleName, $rule) {
//         $map = [
//             self::RULE_REQUIRED => 'validateRequired',
//             self::RULE_EMAIL    => 'validateEmail',
//             self::RULE_MIN      => 'validateMin',
//             self::RULE_MAX      => 'validateMax',
//             self::RULE_MATCH    => 'validateMatch',
//             self::RULE_UNIQUE   => 'validateUnique',
//         ];

//         if (isset($map[$ruleName])) {
//             $method = $map[$ruleName];
//             $this->{$method}($att, $value, $rule);
//         }
//     }

//     // ----------------- RULE HANDLERS -----------------
//     private function validateRequired($att, $value, $rule) {
//         if (!$value) {
//             $this->addError($att, self::RULE_REQUIRED);
//         }
//     }

//     private function validateEmail($att, $value, $rule) {
//         if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
//             $this->addError($att, self::RULE_EMAIL);
//         }
//     }

//     private function validateMin($att, $value, $rule) {
//         if (strlen($value) < $rule['min']) {
//             $this->addError($att, self::RULE_MIN, ['min' => $rule['min']]);
//         }
//     }

//     private function validateMax($att, $value, $rule) {
//         if (strlen($value) > $rule['max']) {
//             $this->addError($att, self::RULE_MAX, ['max' => $rule['max']]);
//         }
//     }

//     private function validateMatch($att, $value, $rule) {
//         if ($value !== $this->{$rule['match']}) {
//             $this->addError($att, self::RULE_MATCH, ['match' => $this->getLabel($rule['match'])]);
//         }
//     }

//     private function validateUnique($att, $value, $rule) {
//         $className = $rule['class'];
//         $uniqatt   = $rule['attribute'] ?? $att;
//         $tableName = $className::tableName();

//         $statement = Application::$app->db
//             ->prepare("SELECT * FROM $tableName WHERE $uniqatt = :$uniqatt");
//         $statement->bindValue(":$uniqatt", $value);
//         $statement->execute();

//         if ($statement->fetchObject()) {
//             $this->addError($att, self::RULE_UNIQUE, ['field' => $this->getLabel($att)]);
//         }
//     }

//     // ----------------- ERRORS -----------------
//     public function addError(string $att, string $rule, $params = []) {
//         $message = $this->errorMessages()[$rule] ?? '';

//         // Always replace attribute name (with label support)
//         $message = str_replace('{{ att }}', $this->getLabel($att), $message);

//         // Replace any extra params (min, max, match, etc.)
//         foreach ($params as $key => $value) {
//             $message = str_replace("{{ $key }}", $value, $message);
//         }

//         $this->errors[$att][] = $message;
//     }

//     public function errorMessages() {
//         return [
//             self::RULE_REQUIRED => '{{ att }} is required',
//             self::RULE_EMAIL    => '{{ att }} must be a valid email address',
//             self::RULE_MIN      => '{{ att }} must be at least {{ min }} characters long',
//             self::RULE_MAX      => '{{ att }} must not exceed {{ max }} characters',
//             self::RULE_MATCH    => '{{ att }} must match {{ match }}',
//             self::RULE_UNIQUE   => '{{ att }} is already taken',
//         ];
//     }

//     public function hasError($att) {
//         return $this->errors[$att] ?? false;
//     }

//     public function getFirstError($att) {
//         return $this->errors[$att][0] ?? false;
//     }
// }
