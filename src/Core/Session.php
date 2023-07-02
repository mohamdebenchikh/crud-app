<?php

namespace App\Core;

class Session
{
    public static function start()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
            self::clearReadFlashMessages();
        }
    }

    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function get($key, $default = null)
    {
        return $_SESSION[$key] ?? $default;
    }

    public static function has($key)
    {
        return isset($_SESSION[$key]);
    }

    public static function remove($key)
    {
        unset($_SESSION[$key]);
    }

    public static function setFlash($key, $message)
    {
        $_SESSION['flash'][$key] = $message;
    }

    public static function hasFlash($key)
    {
        return isset($_SESSION['flash'][$key]);
    }

    public static function getFlash($key)
    {
        if (self::hasFlash($key)) {
            $message = $_SESSION['flash'][$key];
            self::markFlashMessageAsRead($key);
            return $message;
        }
        return null;
    }

    private static function clearReadFlashMessages()
    {
        $readFlashMessagesKeys = self::get('read_flash_messages_keys', []);
        foreach ($readFlashMessagesKeys as $key) {
            unset($_SESSION['flash'][$key]);
        }
        self::remove('read_flash_messages_keys');
    }

    private static function markFlashMessageAsRead($key)
    {
        $readFlashMessagesKeys = self::get('read_flash_messages_keys', []);
        $readFlashMessagesKeys[] = $key;
        self::set('read_flash_messages_keys', $readFlashMessagesKeys);
    }
}
