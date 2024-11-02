from django.contrib import admin
from .models import Empresa

class EmpresaAdmin(admin.ModelAdmin):
    list_display = ('id', 'nome', 'is_active')  # Use 'nome' se esse for o nome correto do campo
    search_fields = ('nome',)
    list_filter = ('is_active',)

admin.site.register(Empresa, EmpresaAdmin)
