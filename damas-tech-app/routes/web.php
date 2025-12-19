<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Company;

Route::get('/', function () {
    return response()->json([
        'name' => 'Damas Tech API',
        'status' => 'ok',
        'health' => url('/api/health'),
        'docs' => url('/api/docs/openapi'),
    ]);
});

// Rotas de preview de e-mail (somente para ambiente de desenvolvimento)
Route::get('/_preview/email/user-welcome', function () {
    $user = new User(['name' => 'Maria da Silva']);

    return view('emails.user_welcome', compact('user'));
});

Route::get('/_preview/email/company-welcome', function () {
    $company = new Company(['name' => 'Empresa Exemplo']);

    return view('emails.company_welcome', compact('company'));
});

Route::get('/_preview/email/user-progress', function () {
    $user = new User(['name' => 'Maria da Silva']);

    return view('emails.user_progress', [
        'user' => $user,
        'courseTitle' => 'Minicurso de Vendas: da prospecção à gestão',
        'completed' => 5,
        'total' => 10,
        'percentage' => 50,
    ]);
});

Route::get('/_preview/email/user-certificate', function () {
    $user = new User(['name' => 'Maria da Silva']);

    return view('emails.user_certificate', [
        'user' => $user,
        'courseTitle' => 'Minicurso de Vendas: da prospecção à gestão',
        'courseId' => 123,
        'certificateCode' => 'DT-123-ABC',
        'certificateUrl' => config('app.url') . '/certificados/DT-123-ABC',
    ]);
});

// Preview de certificado em tela cheia (para download/print ou geração de PDF)
Route::get('/_preview/certificate/course', function () {
    $user = new User(['name' => 'Maria da Silva']);

    return view('certificates.course_certificate', [
        'user' => $user,
        'courseTitle' => 'HTML para iniciantes',
        'description' => 'Certificamos que a estudante concluiu com êxito o curso "HTML para iniciantes", participando das aulas teóricas e práticas e cumprindo a carga horária proposta.',
        'completedAt' => now()->format('d/m/Y'),
        'hours' => '10 horas',
        'modules' => '5 módulos',
    ]);
});
