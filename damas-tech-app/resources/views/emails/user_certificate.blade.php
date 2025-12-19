<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Seu certificado Damas Tech</title>
    <style>
        body { margin: 0; padding: 0; background-color: #1E1E1E; font-family: 'Lexend Deca', Arial, sans-serif; color: #FFFFFF; }
        .wrapper { width: 100%; padding: 24px 0; }
        .container { max-width: 640px; margin: 0 auto; background: linear-gradient(135deg, #35055C, #4A0676); border-radius: 20px; overflow: hidden; box-shadow: 0 18px 38px rgba(0,0,0,0.45); }
        .header { padding: 24px 32px 8px; }
        .logo { color: #FCD9FF; font-size: 26px; font-weight: 700; letter-spacing: 1px; }
        .logo span { color: #FFFFFF; }
        .hero { padding: 12px 32px 32px; background: radial-gradient(circle at top right, #E113FC33, transparent 60%); }
        .badge { display: inline-block; background-color: #FCD9FF; color: #35055C; font-size: 12px; padding: 6px 14px; border-radius: 999px; text-transform: uppercase; letter-spacing: 0.08em; margin: 8px 0 18px; }
        h1 { font-family: 'Reem Kufi Fun', system-ui, sans-serif; font-size: 26px; margin: 0 0 12px; }
        h2 { font-size: 18px; margin: 0 0 20px; color: #FCD9FF; }
        p { font-size: 14px; line-height: 1.7; margin: 0 0 10px; }
        .cert-box { margin: 22px 0; padding: 18px 20px; border-radius: 16px; background-color: #1E1E1E; border: 1px solid rgba(252,217,255,0.4); }
        .cert-title { font-size: 16px; font-weight: 600; margin-bottom: 4px; color: #FCD9FF; }
        .cta { margin: 24px 0 6px; }
        .button { display: inline-block; padding: 12px 26px; background-color: #FCD9FF; color: #35055C !important; text-decoration: none; border-radius: 999px; font-size: 14px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; }
        .note { font-size: 12px; color: #E5E5E5; margin-top: 10px; }
        .footer { padding: 16px 28px 22px; font-size: 12px; color: #CCCCCC; background-color: #1E1E1E; border-radius: 0 0 20px 20px; }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="container">
        <div class="header">
            <div class="logo">damas<span>tech</span></div>
        </div>

        <div class="hero">
            <div class="badge">Certificado disponível</div>
            <h1>Parabéns, {{ $user->name }}!</h1>
            <h2>Você concluiu o curso {{ $courseTitle ?? ('#' . ($courseId ?? '')) }}.</h2>

            <p>
                Este é um marco importante na sua jornada. Seu certificado já está pronto para ser
                baixado e compartilhado com recrutadores, redes sociais e no seu portfólio.
            </p>

            <div class="cert-box">
                <div class="cert-title">Certificado Damas Tech</div>
                <p style="margin: 0;">
                    Curso: <strong>{{ $courseTitle ?? 'Curso Damas Tech' }}</strong><br>
                    Concluído por: <strong>{{ $user->name }}</strong><br>
                    Código: <strong>{{ $certificateCode ?? ('DT-' . ($courseId ?? '')) }}</strong>
                </p>
            </div>

            <div class="cta">
                <a href="{{ $certificateUrl ?? config('app.url') }}" class="button" target="_blank">
                    Baixar certificado
                </a>
            </div>

            <p class="note">
                Guarde este e-mail: o link do certificado pode ser usado como comprovação em processos
                seletivos e atualizações de currículo.
            </p>
        </div>

        <div class="footer">
            <p>
                Damas Tech &mdash; conectando seu aprendizado às próximas oportunidades na tecnologia.
            </p>
        </div>
    </div>
</div>
</body>
</html>
