<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Suporte Damas Tech</title>
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
        }

        h1 {
            font-size: 22px;
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

        .ticket-info {
            background-color: #F9F0FF;
            border-left: 4px solid #E113FC;
            padding: 16px;
            border-radius: 4px;
            margin-bottom: 24px;
        }

        .ticket-label {
            font-size: 12px;
            text-transform: uppercase;
            color: #888;
            font-weight: 700;
            letter-spacing: 0.05em;
        }

        .ticket-id {
            font-size: 16px;
            color: #4A0676;
            font-weight: 600;
            margin-top: 4px;
        }

        .footer {
            padding: 32px;
            text-align: center;
            font-size: 12px;
            color: #888888;
            background-color: #FAFAFA;
            border-top: 1px solid #EEEEEE;
        }

        .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #F0F0F0;
            color: #333 !important;
            text-decoration: none;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 600;
            margin-top: 12px;
        }

        .button:hover {
            background-color: #E0E0E0;
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
                <h1>Olá, {{ $name ?? 'pessoal' }}!</h1>

                <p>
                    Recebemos sua mensagem e nossa equipe de suporte já está analisando sua solicitação.
                </p>

                <div class="ticket-info">
                    <div class="ticket-label">Número do Chamado</div>
                    <div class="ticket-id">#{{ $ticketId ?? '2024-8892' }}</div>
                </div>

                <p>
                    Nosso tempo médio de resposta é de <strong>24 horas úteis</strong>.
                    Se você tiver mais informações para adicionar, basta responder a este e-mail.
                </p>

                <p style="margin-top: 32px; border-top: 1px solid #EEE; padding-top: 24px;">
                    <strong>Sua mensagem original:</strong><br>
                    <em
                        style="color: #777;">"{{ $originalMessage ?? 'Gostaria de saber como altero meu e-mail de cadastro...' }}"</em>
                </p>

                <div style="text-align: center;">
                    <a href="{{ config('app.url') }}/suporte" class="button">Acessar Central de Ajuda</a>
                </div>
            </div>

            <div class="footer">
                <p>
                    Damas Tech Support Team<br>
                    <a href="mailto:suporte@damas.tech"
                        style="color: #E113FC; text-decoration: none;">suporte@damas.tech</a>
                </p>
            </div>
        </div>
    </div>
</body>

</html>