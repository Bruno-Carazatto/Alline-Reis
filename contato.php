<?php
declare(strict_types=1);
session_start();
require_once __DIR__ . '/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$csrfTokenForm = $_POST['csrf_token'] ?? '';
$csrfTokenSession = $_SESSION['csrf_token'] ?? '';

if (!$csrfTokenForm || !$csrfTokenSession || !hash_equals($csrfTokenSession, $csrfTokenForm)) {
    $_SESSION['form_error'] = 'Token de segurança inválido. Tente novamente.';
    header('Location: index.php#contato');
    exit;
}

$nome = trim($_POST['nome'] ?? '');
$telefone = trim($_POST['telefone'] ?? '');
$email = trim($_POST['email'] ?? '');
$assunto = trim($_POST['assunto'] ?? '');
$mensagem = trim($_POST['mensagem'] ?? '');

if (
    $nome === '' ||
    $telefone === '' ||
    $email === '' ||
    $assunto === '' ||
    $mensagem === ''
) {
    $_SESSION['form_error'] = 'Preencha todos os campos obrigatórios.';
    header('Location: index.php#contato');
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['form_error'] = 'Informe um e-mail válido.';
    header('Location: index.php#contato');
    exit;
}

if (mb_strlen($nome) > 120 || mb_strlen($email) > 150 || mb_strlen($assunto) > 150 || mb_strlen($mensagem) > 2000) {
    $_SESSION['form_error'] = 'Um ou mais campos ultrapassaram o limite permitido.';
    header('Location: index.php#contato');
    exit;
}

try {
    $sql = "INSERT INTO contatos (nome, telefone, email, assunto, mensagem, ip_usuario, criado_em)
            VALUES (:nome, :telefone, :email, :assunto, :mensagem, :ip_usuario, NOW())";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nome'       => $nome,
        ':telefone'   => $telefone,
        ':email'      => $email,
        ':assunto'    => $assunto,
        ':mensagem'   => $mensagem,
        ':ip_usuario' => $_SERVER['REMOTE_ADDR'] ?? null
    ]);

    $assuntoEmail = 'Novo contato pela Landing Page de Psicologia';

    $corpoEmail = "
    <html>
    <head>
        <meta charset='UTF-8'>
        <title>Novo contato</title>
    </head>
    <body style='font-family: Arial, sans-serif; background:#f8f8f8; padding:20px; color:#333;'>
        <div style='max-width:650px; margin:0 auto; background:#ffffff; border-radius:12px; overflow:hidden; border:1px solid #ddd;'>
            <div style='background:#556b2f; color:#fff; padding:20px;'>
                <h2 style='margin:0;'>Novo contato recebido 🌿</h2>
            </div>

            <div style='padding:20px;'>
                <table style='width:100%; border-collapse:collapse;'>
                    <tr>
                        <td style='padding:10px; border:1px solid #ddd; font-weight:bold; width:180px;'>Nome</td>
                        <td style='padding:10px; border:1px solid #ddd;'>" . htmlspecialchars($nome, ENT_QUOTES, 'UTF-8') . "</td>
                    </tr>
                    <tr>
                        <td style='padding:10px; border:1px solid #ddd; font-weight:bold;'>WhatsApp</td>
                        <td style='padding:10px; border:1px solid #ddd;'>" . htmlspecialchars($telefone, ENT_QUOTES, 'UTF-8') . "</td>
                    </tr>
                    <tr>
                        <td style='padding:10px; border:1px solid #ddd; font-weight:bold;'>E-mail</td>
                        <td style='padding:10px; border:1px solid #ddd;'>" . htmlspecialchars($email, ENT_QUOTES, 'UTF-8') . "</td>
                    </tr>
                    <tr>
                        <td style='padding:10px; border:1px solid #ddd; font-weight:bold;'>Assunto</td>
                        <td style='padding:10px; border:1px solid #ddd;'>" . htmlspecialchars($assunto, ENT_QUOTES, 'UTF-8') . "</td>
                    </tr>
                    <tr>
                        <td style='padding:10px; border:1px solid #ddd; font-weight:bold;'>Mensagem</td>
                        <td style='padding:10px; border:1px solid #ddd;'>" . nl2br(htmlspecialchars($mensagem, ENT_QUOTES, 'UTF-8')) . "</td>
                    </tr>
                </table>
            </div>
        </div>
    </body>
    </html>
    ";

    $headers = [];
    $headers[] = 'MIME-Version: 1.0';
    $headers[] = 'Content-type: text/html; charset=UTF-8';
    $headers[] = 'From: ' . $nomeRemetenteSistema . ' <' . $emailRemetenteSistema . '>';
    $headers[] = 'Reply-To: ' . $nome . ' <' . $email . '>';

    @mail($emailDestino, $assuntoEmail, $corpoEmail, implode("\r\n", $headers));

    $_SESSION['form_success'] = 'Mensagem enviada com sucesso! Em breve você receberá um retorno.';
    header('Location: obrigado.php');
    exit;

} catch (Throwable $e) {
    $_SESSION['form_error'] = 'Não foi possível enviar sua mensagem no momento. Tente novamente.';
    header('Location: index.php#contato');
    exit;
}