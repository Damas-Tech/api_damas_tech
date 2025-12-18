<?php

namespace App\Support;

class ErrorMessages
{
    /**
     * Mapa centralizado de mensagens de erro.
     */
    protected const MESSAGES = [
        'auth.invalid_credentials' => 'As credenciais informadas são inválidas.',
        'auth.unauthenticated' => 'Você precisa estar autenticada para acessar este recurso.',

        'jobs.create_failed' => 'Não foi possível criar a vaga no momento. Tente novamente mais tarde.',
        'jobs.forbidden' => 'Você não tem permissão para gerenciar vagas desta empresa.',

        'match.unexpected_error' => 'Ocorreu um erro ao calcular os matches. Tente novamente mais tarde.',

        'course.not_found' => 'Curso não encontrado.',
        'module.not_found' => 'Módulo não encontrado.',

        'materials.not_found' => 'Material não encontrado.',

        'generic.unexpected_error' => 'Ocorreu um erro inesperado. Nossa equipe já foi notificada.',
    ];

    public static function get(string $key, ?string $default = null): string
    {
        return static::MESSAGES[$key] ?? ($default ?? static::MESSAGES['generic.unexpected_error']);
    }
}
