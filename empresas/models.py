from django.db import models

class Empresa(models.Model):
    nome = models.CharField(max_length=255)
    is_active = models.BooleanField(default=True)
    cnpj = models.CharField(max_length=14, unique=True)
    email = models.EmailField(unique=True)
    senha = models.CharField(max_length=8)
    
    def __str__(self):
        return self.nome