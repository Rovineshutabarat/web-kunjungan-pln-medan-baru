<?php
// File: middleware/AuthMiddleware.php
session_start();

class AuthMiddleware {
    public static function checkAuth() {
        if (!isset($_SESSION['petugas_login']) || $_SESSION['petugas_login'] !== true) {
            header('Location: login.php');
            exit();
        }
    }

    public static function checkRole($allowedRoles = ['admin', 'petugas']) {
        if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], $allowedRoles)) {
            header('Location: unauthorized.php');
            exit();
        }
    }

    public static function isLoggedIn() {
        return isset($_SESSION['petugas_login']) && $_SESSION['petugas_login'] === true;
    }

    public static function getUserData() {
        if (self::isLoggedIn()) {
            return [
                'petugas_login' => $_SESSION['petugas_login'],
                'id' => $_SESSION['id'],
                'username' => $_SESSION['username'],
                'nama' => $_SESSION['nama'],
                'role' => $_SESSION['role']
            ];
        }
        return null;
    }
}
?>