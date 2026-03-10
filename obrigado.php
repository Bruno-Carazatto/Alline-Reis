<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mensagem enviada com sucesso</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #556b2f, #6d7d43);
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        .success-card {
            max-width: 600px;
            width: 100%;
            background: #fff;
            border-radius: 24px;
            padding: 40px 30px;
            text-align: center;
            box-shadow: 0 20px 50px rgba(0,0,0,0.15);
        }

        .success-icon {
            width: 90px;
            height: 90px;
            margin: 0 auto 20px;
            border-radius: 50%;
            background: rgba(85, 107, 47, 0.12);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 42px;
        }

        h1 {
            font-size: 2rem;
            font-weight: 800;
            color: #445624;
            margin-bottom: 15px;
        }

        p {
            color: #566354;
            margin-bottom: 24px;
        }

        .btn-voltar {
            background: #8c6a43;
            color: #fff;
            border: none;
            border-radius: 999px;
            padding: 12px 28px;
            font-weight: 700;
            text-decoration: none;
        }

        .btn-voltar:hover {
            background: #a17649;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="success-card">
        <div class="success-icon">✅</div>
        <h1>Mensagem enviada com sucesso!</h1>
        <p>Obrigado pelo contato. Em breve você receberá um retorno.</p>
        <a href="index.php" class="btn-voltar">Voltar para a página inicial</a>
    </div>
</body>
</html>