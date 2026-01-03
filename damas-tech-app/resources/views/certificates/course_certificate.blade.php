<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Certificado Damas Tech</title>
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
            /* ~A4 landscape @96dpi */
            height: 794px;
            margin: 20px auto;
            background: #ffffff;
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.25);
            display: flex;
            overflow: hidden;
        }

        .left {
            width: 32%;
            background: linear-gradient(180deg, #4A0676 0%, #E113FC 50%, #35055C 100%);
            color: #ffffff;
            padding: 48px 36px;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .brand {
            font-size: 28px;
            font-weight: 700;
            letter-spacing: 1px;
        }

        .brand span {
            color: #E113FC;
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
            background: radial-gradient(circle at 0 0, #F7F2FF 0, #FFFFFF 40%, #FCD9FF 110%);
        }

        .badge {
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.12em;
            color: #4A0676;
            padding: 6px 14px;
            border-radius: 999px;
            border: 1px solid #E113FC;
            display: inline-block;
        }

        .title-main {
            margin-top: 8px;
            font-size: 26px;
            font-weight: 800;
            color: #35055C;
        }

        .title-sub {
            margin-top: 4px;
            font-size: 16px;
            color: #555555;
        }

        .course-name-label {
            margin-top: 36px;
            font-size: 14px;
            color: #4A0676;
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

        .meta {
            margin-top: 40px;
            display: flex;
            gap: 32px;
            font-size: 12px;
            color: #555555;
        }

        .meta-item strong {
            display: block;
            font-size: 13px;
            color: #35055C;
            margin-bottom: 4px;
        }

        .badge-row {
            margin-top: 18px;
            display: flex;
            gap: 10px;
            font-size: 11px;
        }

        .pill {
            padding: 6px 10px;
            border-radius: 999px;
            background-color: #FCD9FF;
            color: #4A0676;
            font-weight: 600;
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

        .watermark {
            position: absolute;
            right: -40px;
            bottom: -80px;
            width: 320px;
            height: 320px;
            border-radius: 50%;
            background: radial-gradient(circle at 30% 0, #FCD9FF 0, #FCD9FF 30%, #4A0676 70%, #35055C 100%);
            opacity: 0.12;
        }

        .footer-bar {
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            height: 42px;
            background: linear-gradient(90deg, #35055C, #4A0676, #E113FC);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 40px;
            box-sizing: border-box;
            color: #FCD9FF;
            font-size: 11px;
        }

        .code-box {
            border-radius: 6px;
            border: 1px solid rgba(255, 255, 255, 0.6);
            padding: 4px 10px;
            font-family: monospace;
            background-color: rgba(0, 0, 0, 0.08);
        }

        .qr-placeholder {
            position: absolute;
            top: 56px;
            right: 64px;
            width: 76px;
            height: 76px;
            border-radius: 12px;
            border: 1px dashed #4A0676;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 9px;
            color: #4A0676;
            background-color: rgba(252, 217, 255, 0.3);
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
            <div>
                <!-- Logo area -->
                <div style="margin-bottom: 40px;">
                    @if($logoData)
                        <img src="data:image/png;base64,{{ $logoData }}" alt="Damas Tech"
                            style="max-width: 160px; background: white; padding: 12px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.2);">
                    @else
                        <h1 style="color: white">Damas Tech</h1>
                    @endif
                </div>

                <div class="student-name">{{ $user->name ?? 'Nome da Aluna' }}</div>
                <div class="role"
                    style="text-transform: uppercase; letter-spacing: 0.1em; margin-top: 10px; font-size: 11px;">
                    Certificado de Conclusão</div>
            </div>

            <div style="font-size: 11px; opacity: 0.8; line-height: 1.5;">
                "O futuro da tecnologia é feminino.<br>Parabéns por fazer parte dessa transformação."
            </div>

            <div class="role" style="margin-top: auto;">
                Damas Tech Education<br>
                <span style="opacity: 0.6; font-size: 10px;">CNPJ 12.345.678/0001-99</span>
            </div>
        </div>
        <div class="right">
            <div class="qr-placeholder">
                <span style="opacity: 0.5;">QR Verificação</span>
            </div>

            <div class="badge">Certificado Oficial</div>

            <div class="title-main" style="font-size: 32px; margin-top: 16px;">Certificado de Excelência</div>
            <div class="title-sub" style="font-size: 16px; margin-top: 8px; color: #666;">
                Conferido a <strong>{{ $user->name ?? 'Nome da Aluna' }}</strong>
            </div>

            <div style="margin-top: 48px; position: relative; z-index: 10;">
                <div class="course-name-label"
                    style="text-transform: uppercase; letter-spacing: 0.1em; color: #888; font-size: 10px;">Curso
                    Concluído</div>
                <div class="course-name" style="font-size: 32px; color: #4A0676; margin-top: 4px;">
                    {{ $courseTitle ?? 'Título do Curso' }}
                </div>

                <p class="description"
                    style="font-size: 14px; margin-top: 24px; color: #555; leading-trim: both; text-edge: cap;">
                    {{ $description ?? 'Certificamos que a estudante completou com êxito a trilha educacional proposta, demonstrando dedicação e domínio dos conceitos abordados. A Damas Tech atesta a competência técnica e o comprometimento demonstrados durante toda a jornada de aprendizado.' }}
                </p>
            </div>

            <div class="badge-row" style="margin-top: 32px;">
                <div class="pill">🌟 {{ $modules ?? '5 módulos' }}</div>
                <div class="pill">⏱ {{ $hours ?? '10 horas' }}</div>
                <div class="pill">📅 {{ isset($completedAt) ? $completedAt : now()->format('d/m/Y') }}</div>
            </div>

            <div class="signatures">
                <div class="sign-block" style="text-align: left;">
                    <div class="sign-line"></div>
                    <strong>Andressa Silva Pereira</strong><br>
                    <span style="opacity: 0.7;">CTO Damas Tech</span>
                </div>
                <div class="sign-block" style="text-align: left;">
                    <div class="sign-line"></div>
                    <strong>Coordenação Pedagógica</strong><br>
                    <span style="opacity: 0.7;">Equipe Brasil</span>
                </div>
            </div>

            <div class="watermark"
                style="background: url('{{ public_path('images/logo.png') }}') no-repeat center center; background-size: contain; opacity: 0.03; width: 400px; height: 400px; border-radius: 0; right: 40px; bottom: 40px;">
            </div>

            <div class="footer-bar" style="background: #35055C; color: white;">
                <div style="display: flex; gap: 20px; align-items: center;">
                    <span>damas.tech</span>
                    <span style="opacity: 0.5;">|</span>
                    <span>Educação e Empregabilidade</span>
                </div>
                <div class="code-box" style="border-color: rgba(255,255,255,0.2); background: rgba(255,255,255,0.05);">
                    Auth: {{ $certificateCode ?? 'DT-GEN-001' }}</div>
            </div>
        </div>
    </div>
</body>

</html>