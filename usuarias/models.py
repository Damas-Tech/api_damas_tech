from django.db import models
from django.contrib.auth.models import AbstractBaseUser, BaseUserManager

class Usuario(AbstractBaseUser):
    nome = models.CharField(max_length=30)
    sobrenome = models.CharField(max_length=30)
    cpf = models.CharField(max_length=11, unique=True)
    email = models.EmailField(unique=True) 
    is_active = models.BooleanField(default=True)
    is_staff = models.BooleanField(default=False)

    USERNAME_FIELD = 'email'
    REQUIRED_FIELDS = ['nome', 'sobrenome', 'cpf']

    objects = BaseUserManager()

    def __str__(self):
        return self.email
