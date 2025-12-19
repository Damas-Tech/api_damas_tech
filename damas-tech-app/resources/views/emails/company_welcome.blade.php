<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Bem-vinda à Damas Tech Empresas</title>
    <style>
        body { margin: 0; padding: 0; background-color: #F7F7F7; font-family: 'Lexend Deca', Arial, sans-serif; color: #1E1E1E; }
        .wrapper { width: 100%; padding: 24px 0; }
        .container { max-width: 600px; margin: 0 auto; background-color: #FFFFFF; border-radius: 16px; overflow: hidden; }
        .header { background: linear-gradient(90deg, #35055C, #4A0676); padding: 24px 32px; }
        .logo { color: #FCD9FF; font-size: 26px; font-weight: 700; letter-spacing: 1px; }
        .logo span { color: #FFFFFF; }
        .hero { padding: 32px; }
        .badge { display: inline-block; background-color: #FCD9FF; color: #35055C; font-size: 12px; padding: 6px 12px; border-radius: 999px; text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 16px; }
        h1 { font-family: 'Reem Kufi Fun', system-ui, sans-serif; font-size: 24px; margin: 0 0 10px; color: #FFFFFF; }
        h2 { font-size: 18px; margin: 0 0 18px; color: #35055C; }
        p { font-size: 14px; line-height: 1.6; margin: 0 0 12px; }
        .highlight { color: #4A0676; font-weight: 600; }
        .cta { margin: 24px 0 8px; }
        .button { display: inline-block; padding: 12px 24px; background-color: #4A0676; color: #FFFFFF !important; text-decoration: none; border-radius: 999px; font-size: 14px; font-weight: 600; }
        .button:hover { background-color: #35055C; }
        .footer { padding: 20px 32px 28px; font-size: 12px; color: #555555; background-color: #F7F7F7; }
        .metrics { margin-top: 16px; padding: 12px 16px; border-radius: 12px; background-color: #FCD9FF; font-size: 13px; }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="container">
        <div class="header">
            <div class="logo">damas<span>tech</span></div>
        </div>

        <div class="hero">
            <div class="badge">Conta empresa criada</div>
            <h2>Olá, {{ $company->name ?? 'time de recrutamento' }}!</h2>

            <p>
                Sua empresa agora faz parte da <span class="highlight">rede de talentos da Damas Tech</span>.
                Vamos te ajudar a se conectar com mulheres em tecnologia que combinam com a cultura e as
                necessidades técnicas da sua equipe.
            </p>

            <div class="metrics">
                <strong>Próximos passos sugeridos:</strong>
                <ul style="margin: 8px 0 0 18px; padding: 0;">
                    <li>Complete o perfil da empresa (cultura, stack, benefícios).</li>
                    <li>Cadastre suas primeiras oportunidades de vagas.</li>
                    <li>Ative o match para receber indicações de candidatas.</li>
                </ul>
            </div>

            <div class="cta">
                <a href="{{ config('app.url') }}" class="button" target="_blank">
                    Acessar painel da empresa
                </a>
            </div>
        </div>

        <div class="footer">
            <p>
                Damas Tech para Empresas &mdash; contratações mais diversas, times mais fortes.
            </p>
        </div>
    </div>
</div>
</body>
</html>
