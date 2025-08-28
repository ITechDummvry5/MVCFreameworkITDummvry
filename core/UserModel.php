<?php 

namespace app\core;

use app\core\DB\DbModel;

abstract class UserModel extends DbModel {

    abstract public function getDisplayName(): string;
}
