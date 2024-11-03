from django.db import models
from django.contrib.auth.hashers import make_password, check_password

class Empresa(models.Model):
    nome = models.CharField(max_length=255)
    is_active = models.BooleanField(default=True)
    cnpj = models.CharField(max_length=14, unique=True)
    email = models.EmailField(unique=True)
    senha = models.CharField(max_length=128)

    def set_password(self, password):
        self.senha = make_password(password)

    def check_password(self, password):
        return check_password(password, self.senha)

    def __str__(self):
        return self.nome
