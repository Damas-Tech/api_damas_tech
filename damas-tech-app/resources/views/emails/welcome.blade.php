<?php
@component('mail::message')
# Introduction

@component('mail::message')
# Olá {{ $user->name }}!

Bem-vindo(a) à **Damas.Tech**. Estamos felizes em ter você conosco.

@component('mail::button', ['url' => config('app.url')])
Acessar Plataforma
@endcomponent

Obrigado,<br>
Equipe Damas.Tech
@endcomponent
