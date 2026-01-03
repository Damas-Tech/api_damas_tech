<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Certificado de Projeto Damas Tech</title>
    <style>
        html,
        body {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            font-family: 'Lexend Deca', Arial, sans-serif;
            background-color: #e5e5e5;
        }

        .page {
            width: 1123px;
            height: 794px;
            margin: 20px auto;
            background: #ffffff;
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.25);
            display: flex;
            overflow: hidden;
        }

        .left {
            width: 32%;
            background: linear-gradient(135deg, #00C9FF 0%, #92FE9D 100%);
            color: #004e64;
            padding: 48px 36px;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .student-name {
            margin-top: 80px;
            font-size: 26px;
            font-weight: 700;
            line-height: 1.2;
        }

        .role {
            margin-top: 16px;
            font-size: 13px;
            opacity: 0.9;
        }

        .right {
            width: 68%;
            padding: 56px 64px;
            box-sizing: border-box;
            position: relative;
            background: radial-gradient(circle at 0 0, #F0FDFF 0, #FFFFFF 40%, #E6FFF0 110%);
        }

        .badge {
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.12em;
            color: #00768e;
            padding: 6px 14px;
            border-radius: 999px;
            border: 1px solid #00C9FF;
            display: inline-block;
        }

        .title-main {
            margin-top: 8px;
            font-size: 26px;
            font-weight: 800;
            color: #004e64;
        }

        .title-sub {
            margin-top: 4px;
            font-size: 16px;
            color: #555555;
        }

        .course-name-label {
            margin-top: 36px;
            font-size: 14px;
            color: #00768e;
        }

        .course-name {
            font-size: 24px;
            font-weight: 700;
            color: #1E1E1E;
        }

        .description {
            margin-top: 20px;
            font-size: 13px;
            line-height: 1.6;
            color: #555555;
            max-width: 540px;
        }

        .signatures {
            position: absolute;
            bottom: 72px;
            left: 64px;
            right: 64px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }

        .sign-block {
            width: 40%;
            text-align: center;
            font-size: 11px;
            color: #555555;
        }

        .sign-line {
            border-bottom: 1px solid #999999;
            margin-bottom: 6px;
            padding-bottom: 18px;
        }

        .footer-bar {
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            height: 42px;
            background: linear-gradient(90deg, #004e64, #00768e, #00C9FF);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 40px;
            box-sizing: border-box;
            color: #E0F7FA;
            font-size: 11px;
        }

        .code-box {
            border-radius: 6px;
            border: 1px solid rgba(255, 255, 255, 0.6);
            padding: 4px 10px;
            font-family: monospace;
            background-color: rgba(0, 0, 0, 0.08);
        }
    </style>
</head>

<body>
    @php
        $logoPath = public_path('images/logo.png');
        $logoData = '';
        if (file_exists($logoPath)) {
            $logoData = base64_encode(file_get_contents($logoPath));
        }
    @endphp
    <div class="page">
        <div class="left">
            <div style="margin-bottom: 40px;">
                @if($logoData)
                    <img src="data:image/png;base64,{{ $logoData }}" alt="Damas Tech"
                        style="max-width: 160px; background: white; padding: 12px; border-radius: 8px;">
                @else
                    <h1 style="color: #004e64">Damas Tech</h1>
                @endif
            </div>
            <div class="student-name">{{ $user->name ?? 'Nome da Aluna' }}</div>
            <div class="role"
                style="text-transform: uppercase; letter-spacing: 0.1em; margin-top: 10px; font-size: 11px;">Certificado
                de Projeto Prático</div>

            <div style="font-size: 11px; opacity: 0.8; line-height: 1.5; margin-top: 20px;">
                "Expertise comprovada na prática.<br>Construindo soluções reais."
            </div>

            <div class="role" style="margin-top: auto;">
                Damas Tech Education<br>
                <span style="opacity: 0.6; font-size: 10px;">CNPJ 12.345.678/0001-99</span>
            </div>
        </div>
        <div class="right">
            <div class="badge">Projeto Aprovado</div>
            <div class="title-main" style="font-size: 32px; margin-top: 16px;">Reconhecimento de Habilidade</div>
            <div class="title-sub" style="font-size: 16px; margin-top: 8px; color: #666;">
                Conferido a <strong>{{ $user->name ?? 'Nome da Aluna' }}</strong>
            </div>

            <div style="margin-top: 48px; position: relative; z-index: 10;">
                <div class="course-name-label"
                    style="text-transform: uppercase; letter-spacing: 0.1em; color: #888; font-size: 10px;">Projeto
                    Desenvolvido</div>
                <div class="course-name" style="font-size: 32px; color: #00768e; margin-top: 4px;">
                    {{ $projectTitle ?? 'Título do Projeto' }}
                </div>

                <p class="description" style="font-size: 14px; margin-top: 24px; color: #555;">
                    Certificamos que a estudante submeteu e teve aprovado o projeto prático acima, demonstrando
                    capacidade de aplicar os conhecimentos adquiridos na resolução de problemas reais proposta pela
                    trilha educacional Damas Tech.
                </p>

                @if(isset($courseName))
                    <div style="margin-top: 16px; font-size: 12px; color: #666;">
                        Vinculado ao curso: <strong>{{ $courseName }}</strong>
                    </div>
                @endif
            </div>

            <div class="signatures">
                <div class="sign-block" style="text-align: left;">
                    <div class="sign-line"></div>
                    <strong>Andressa Silva Pereira</strong><br>
                    <span style="opacity: 0.7;">CTO Damas Tech</span>
                </div>
                <div class="sign-block" style="text-align: left;">
                    <div class="sign-line"></div>
                    <strong>Banca Avaliadora</strong><br>
                    <span style="opacity: 0.7;">Equipe Técnica</span>
                </div>
            </div>

            <div class="footer-bar">
                <div style="display: flex; gap: 20px; align-items: center;">
                    <span>damas.tech</span>
                    <span style="opacity: 0.5;">|</span>
                    <span>Projetos Práticos</span>
                </div>
                <div class="code-box">Auth: {{ $certificateCode ?? 'DT-PRJ-001' }}</div>
            </div>
        </div>
    </div>
</body>

</html>