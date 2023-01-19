<?php

namespace config;
// Используем для подключения к базе данных MySQL
use PDO;

class Db
{
    // Учётные данные базы данных
    private string $host = "localhost";
    private string $db_name = "shop";
    private string $username = "root";
    private string $password = "";

    // Получаем соединение с базой данных
    public function getConnection(): PDO
    {
        return new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
    }
}