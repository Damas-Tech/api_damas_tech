@component('mail::message')
# Parabéns {{ $user->name }}!

Você concluiu o curso **ID: {{ $courseId }}** com sucesso. 🎉

@component('mail::button', ['url' => config('app.url')])
Acessar Plataforma
@endcomponent

Continue aprendendo e se destacando!
@endcomponent
