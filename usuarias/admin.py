from django.contrib import admin
from .models import Usuario

class UsuarioAdmin(admin.ModelAdmin):
    list_display = ('id', 'nome', 'sobrenome', 'cpf', 'email')
    list_filter = ('email',)


admin.site.register(Usuario, UsuarioAdmin)
