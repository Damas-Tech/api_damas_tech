from django.contrib import admin
from .models import Empresa

class EmpresaAdmin(admin.ModelAdmin):
    list_display = ('id', 'nome', 'is_active', 'cnpj', 'senha', 'email')
    search_fields = ('nome',)
    list_filter = ('is_active',)

admin.site.register(Empresa, EmpresaAdmin)
