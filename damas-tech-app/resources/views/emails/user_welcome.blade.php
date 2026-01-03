<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Bem-vinda à Damas Tech</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #F7F2FF;
            font-family: 'Lexend Deca', Arial, sans-serif;
            color: #1E1E1E;
        }

        .wrapper {
            width: 100%;
            background-color: #F7F2FF;
            padding: 40px 0;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #FFFFFF;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }

        .header {
            background-color: #FFFFFF;
            padding: 40px 32px 20px;
            text-align: center;
            border-bottom: 1px solid #F0F0F0;
        }

        .logo-img {
            max-width: 160px;
            height: auto;
        }

        .hero {
            padding: 40px 32px;
            text-align: center;
        }

        .badge {
            display: inline-block;
            background-color: #FCD9FF;
            color: #4A0676;
            font-size: 11px;
            font-weight: 700;
            padding: 6px 14px;
            border-radius: 999px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 24px;
        }

        h1 {
            font-size: 24px;
            margin: 0 0 16px;
            color: #35055C;
            font-weight: 700;
        }

        p {
            font-size: 15px;
            line-height: 1.6;
            margin: 0 0 16px;
            color: #555555;
        }

        .cta {
            margin: 32px 0;
        }

        .button {
            display: inline-block;
            padding: 14px 32px;
            background: linear-gradient(90deg, #4A0676, #E113FC);
            color: #FFFFFF !important;
            text-decoration: none;
            border-radius: 999px;
            font-size: 15px;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(225, 19, 252, 0.3);
        }

        .footer {
            padding: 32px;
            text-align: center;
            font-size: 12px;
            color: #888888;
            background-color: #FAFAFA;
            border-top: 1px solid #EEEEEE;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="container">
            <div class="header">
                <!-- Using url() helper for absolute path in emails -->
                <img src="{{ url('images/logo.png') }}" alt="Damas Tech" class="logo-img">
            </div>

            <div class="hero">
                <div class="badge">Cadastro confirmado com sucesso</div>
                <h1>Olá, {{ $user->name }}!</h1>

                <p>
                    Seja muito bem-vinda à <strong>Damas Tech</strong>. Ficamos felizes em ter você aqui.
                </p>

                <p>
                    Nossa missão é conectar você às melhores oportunidades e conteúdos de tecnologia, impulsionando sua
                    carreira para o próximo nível.
                </p>

                <div class="cta">
                    <a href="{{ config('app.url') }}" class="button" target="_blank">
                        Acessar minha conta
                    </a>
                </div>

                <p style="font-size: 13px; color: #999;">
                    Se você não criou esta conta, por favor ignore este e-mail.
                </p>
            </div>

            <div class="footer">
                <p>
                    &copy; {{ date('Y') }} Damas Tech.<br>
                    Educação, comunidade e oportunidades para mulheres na tecnologia.
                </p>
            </div>
        </div>
    </div>
</body>

</html>