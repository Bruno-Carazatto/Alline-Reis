<?php
declare(strict_types=1);

$host = 'localhost';
$dbname = 'psicologia_landing';
$user = 'root';
$pass = 'Lohbru@21';

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO(
        "mysql:host={$host};dbname={$dbname};charset=utf8mb4",
        $user,
        $pass,
        $options
    );
} catch (PDOException $e) {
    die('Erro ao conectar com o banco de dados: ' . $e->getMessage());
}

/*
|--------------------------------------------------------------------------
| CONFIGURAÇÕES DE E-MAIL
|--------------------------------------------------------------------------
| Ajuste os dados abaixo conforme o seu servidor.
| Se quiser começar simples, pode usar a função mail().
| Depois podemos trocar para PHPMailer + SMTP.
*/
$emailDestino = 'seuemail@dominio.com';
$emailRemetenteSistema = 'no-reply@seudominio.com';
$nomeRemetenteSistema = 'Landing Psicologia';