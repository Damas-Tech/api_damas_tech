<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Seu progresso na Damas Tech</title>
    <style>
        body { margin: 0; padding: 0; background-color: #F7F7F7; font-family: 'Lexend Deca', Arial, sans-serif; color: #1E1E1E; }
        .wrapper { width: 100%; padding: 24px 0; }
        .container { max-width: 600px; margin: 0 auto; background-color: #FFFFFF; border-radius: 16px; overflow: hidden; }
        .header { background-color: #4A0676; padding: 20px 28px; }
        .logo { color: #FCD9FF; font-size: 22px; font-weight: 700; letter-spacing: 1px; }
        .logo span { color: #FFFFFF; }
        .hero { padding: 28px; }
        .badge { display: inline-block; background-color: #FCD9FF; color: #4A0676; font-size: 12px; padding: 6px 12px; border-radius: 999px; text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 16px; }
        h1 { font-family: 'Reem Kufi Fun', system-ui, sans-serif; font-size: 22px; margin: 0 0 12px; color: #35055C; }
        p { font-size: 14px; line-height: 1.6; margin: 0 0 10px; }
        .progress-bar { margin: 20px 0; background-color: #F7F7F7; border-radius: 999px; height: 10px; overflow: hidden; }
        .progress-bar-fill { height: 100%; background: linear-gradient(90deg, #4A0676, #E113FC); }
        .stats { font-size: 13px; color: #555555; }
        .cta { margin: 24px 0 8px; }
        .button { display: inline-block; padding: 10px 22px; background-color: #4A0676; color: #FFFFFF !important; text-decoration: none; border-radius: 999px; font-size: 14px; font-weight: 600; }
        .footer { padding: 18px 28px 24px; font-size: 12px; color: #555555; background-color: #F7F7F7; }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="container">
        <div class="header">
            <div class="logo">damas<span>tech</span></div>
        </div>

        <div class="hero">
            <div class="badge">Atualização de progresso</div>
            <h1>Você está avançando, {{ $user->name }}!</h1>

            <p>
                Aqui vai um resumo do seu progresso no curso <strong>{{ $courseTitle ?? 'da Damas Tech' }}</strong>.
            </p>

            <div class="progress-bar">
                <div class="progress-bar-fill" style="width: {{ $percentage ?? 0 }}%;"></div>
            </div>

            <p class="stats">
                {{ $completed ?? 0 }} de {{ $total ?? 0 }} atividades concluídas &mdash;
                <strong>{{ $percentage ?? 0 }}% do curso</strong>.
            </p>

            <p>
                Continue no seu ritmo. Cada módulo concluído te deixa mais perto das oportunidades
                que combinam com o seu momento e com seus objetivos.
            </p>

            <div class="cta">
                <a href="{{ config('app.url') }}" class="button" target="_blank">
                    Retomar curso
                </a>
            </div>
        </div>

        <div class="footer">
            <p>
                Estamos torcendo por você em cada etapa da jornada.
            </p>
        </div>
    </div>
</div>
</body>
</html>
