<?php 

namespace app\core;

class Session {

    protected const FLASH_KEY = 'flash_message';

    public function __construct() {
        session_start();

        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];

        foreach ($flashMessages as $key => &$flashMessage) {
            if (is_array($flashMessage)) {
                $flashMessage['remove'] = true;
            }
        }

        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }

    public function setflash_message($key, $message) {
        $_SESSION[self::FLASH_KEY][$key] = [
            'value'  => $message,
            'remove' => false
        ];
    }

    public function getflash_message($key) {
        $flash = $_SESSION[self::FLASH_KEY][$key] ?? null;

        if (is_array($flash) && isset($flash['value'])) {
            return $flash['value'];
        }

        // fallback in case old string values exist
        return is_string($flash) ? $flash : false;
    }

    public function set($key, $value) {
        $_SESSION[$key] = $value;
    }

    public function get($key) {
        return $_SESSION[$key] ?? false;
    }

    public function remove($key) {
        unset($_SESSION[$key]);
    }

    public function __destruct() {
        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];

        foreach ($flashMessages as $key => $flashMessage) {
            if (is_array($flashMessage) && !empty($flashMessage['remove'])) {
                unset($flashMessages[$key]);
            }
        }

        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }
}
