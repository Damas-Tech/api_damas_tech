<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Redefinição de Senha - Damas Tech</title>
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
            padding: 40px 0;
            background-color: #F7F2FF;
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
            background: linear-gradient(90deg, #E113FC, #4A0676);
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

        .warning-box {
            background-color: #FFF4F4;
            color: #D32F2F;
            padding: 12px;
            border-radius: 8px;
            font-size: 13px;
            margin-top: 24px;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="container">
            <div class="header">
                <img src="{{ url('images/logo.png') }}" alt="Damas Tech" class="logo-img">
            </div>

            <div class="hero">
                <h1>Esqueceu sua senha?</h1>

                <p>
                    Não se preocupe, isso acontece. Recebemos uma solicitação para redefinir a senha da sua conta na
                    <strong>Damas Tech</strong>.
                </p>

                <div class="cta">
                    <!-- Using generic # for template, in real app this is $url -->
                    <a href="{{ $url ?? '#' }}" class="button" target="_blank">
                        Redefinir minha senha
                    </a>
                </div>

                <p style="font-size: 14px;">
                    Este link expira em 60 minutos.
                </p>

                <div class="warning-box">
                    Se você não fez essa solicitação, pode ignorar este e-mail com segurança. Sua senha permanecerá a
                    mesma.
                </div>
            </div>

            <div class="footer">
                <p>
                    &copy; {{ date('Y') }} Damas Tech.<br>
                    Segurança e privacidade em primeiro lugar.
                </p>
            </div>
        </div>
    </div>
</body>

</html>