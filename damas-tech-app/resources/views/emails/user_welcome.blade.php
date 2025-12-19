<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Bem-vinda à Damas Tech</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #FCD9FF;
            font-family: 'Lexend Deca', Arial, sans-serif;
            color: #1E1E1E;
        }
        .wrapper {
            width: 100%;
            background-color: #FCD9FF;
            padding: 24px 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #FFFFFF;
            border-radius: 16px;
            overflow: hidden;
        }
        .header {
            background-color: #35055C;
            padding: 24px 32px;
            text-align: left;
        }
        .logo {
            color: #FCD9FF;
            font-size: 28px;
            font-weight: 700;
            letter-spacing: 1px;
        }
        .logo span {
            color: #E113FC;
        }
        .hero {
            padding: 32px;
        }
        .badge {
            display: inline-block;
            background-color: #FCD9FF;
            color: #35055C;
            font-size: 12px;
            padding: 6px 12px;
            border-radius: 999px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 16px;
        }
        h1 {
            font-family: 'Reem Kufi Fun', system-ui, sans-serif;
            font-size: 26px;
            margin: 0 0 12px;
            color: #4A0676;
        }
        h2 {
            font-size: 18px;
            margin: 0 0 20px;
            color: #35055C;
        }
        p {
            font-size: 14px;
            line-height: 1.6;
            margin: 0 0 12px;
            color: #1E1E1E;
        }
        .cta {
            margin: 28px 0 8px;
        }
        .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #E113FC;
            color: #FFFFFF !important;
            text-decoration: none;
            border-radius: 999px;
            font-size: 14px;
            font-weight: 600;
        }
        .button:hover {
            background-color: #4A0676;
        }
        .highlight {
            color: #E113FC;
            font-weight: 600;
        }
        .footer {
            padding: 20px 32px 28px;
            font-size: 12px;
            color: #555555;
            background-color: #F7F7F7;
        }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="container">
        <div class="header">
            <div class="logo">damas<span>tech</span></div>
        </div>

        <div class="hero">
            <div class="badge">Cadastro confirmado</div>
            <h1>Bem-vinda, {{ $user->name }}!</h1>
            <h2>Que bom ter você na comunidade Damas Tech.</h2>

            <p>
                A partir de agora você tem acesso a conteúdos, trilhas e oportunidades pensadas
                para <span class="highlight">impulsionar sua carreira em tecnologia</span>.
            </p>

            <p>
                Em breve você vai receber recomendações de cursos, vagas compatíveis com seu perfil
                e materiais exclusivos para te apoiar da <strong>primeira linha de código</strong>
                até a sua próxima contratação.
            </p>

            <div class="cta">
                <a href="{{ config('app.url') }}" class="button" target="_blank">
                    Acessar minha conta
                </a>
            </div>

            <p style="font-size: 12px; color: #777777; margin-top: 12px;">
                Se você não criou uma conta na Damas Tech, ignore este e-mail.
            </p>
        </div>

        <div class="footer">
            <p>
                Damas Tech &mdash; educação, comunidade e oportunidades para mulheres na tecnologia.
            </p>
        </div>
    </div>
</div>
</body>
</html>
