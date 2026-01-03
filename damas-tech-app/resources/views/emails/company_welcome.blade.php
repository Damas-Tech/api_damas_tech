<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Bem-vinda à Damas Tech Empresas</title>
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

        .badge {
            display: inline-block;
            background-color: #E113FC;
            color: #FFFFFF;
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
            margin: 0 0 10px;
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
            background: linear-gradient(90deg, #35055C, #4A0676);
            color: #FFFFFF !important;
            text-decoration: none;
            border-radius: 999px;
            font-size: 15px;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(53, 5, 92, 0.3);
        }

        .footer {
            padding: 32px;
            text-align: center;
            font-size: 12px;
            color: #888888;
            background-color: #FAFAFA;
            border-top: 1px solid #EEEEEE;
        }

        .metrics {
            margin-top: 24px;
            padding: 20px;
            border-radius: 8px;
            background-color: #F9F0FF;
            text-align: left;
            font-size: 14px;
            border-left: 4px solid #E113FC;
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
                <div class="badge">Conta Corporativa</div>
                <h1>Olá, {{ $company->name ?? 'Time' }}!</h1>

                <p>
                    Sua empresa agora faz parte da <strong>rede de talentos da Damas Tech</strong>.
                </p>
                <p>
                    Acreditamos que a diversidade constrói tecnologia melhor. Estamos aqui para ajudar você a encontrar
                    profissionais incríveis que combinem com seus desafios.
                </p>

                <div class="metrics">
                    <strong style="color: #4A0676;">Próximos passos:</strong>
                    <ul style="margin: 12px 0 0 20px; padding: 0; color: #555;">
                        <li style="margin-bottom: 6px;">Complete o perfil cultural da empresa.</li>
                        <li style="margin-bottom: 6px;">Publique suas primeiras vagas.</li>
                        <li>Utilize nosso algoritmo de Match.</li>
                    </ul>
                </div>

                <div class="cta">
                    <a href="{{ config('app.url') }}" class="button" target="_blank">
                        Acessar Painel da Empresa
                    </a>
                </div>
            </div>

            <div class="footer">
                <p>
                    &copy; {{ date('Y') }} Damas Tech.<br>
                    Contratações mais diversas, times mais fortes.
                </p>
            </div>
        </div>
    </div>
</body>

</html>