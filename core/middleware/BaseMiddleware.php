<?php 

namespace app\core\middleware;

abstract class BaseMiddleware
{
    abstract public function execute();
}