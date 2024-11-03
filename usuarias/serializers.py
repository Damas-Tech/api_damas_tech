from rest_framework import serializers
from .models import Usuario

class UsuarioSerializer(serializers.ModelSerializer):
    confirmar_senha = serializers.CharField(write_only=True)
    senha = serializers.CharField(write_only=True) 

    class Meta:
        model = Usuario
        fields = ['id', 'nome', 'sobrenome', 'cpf', 'email', 'senha', 'confirmar_senha']
        extra_kwargs = {
            'email': {'required': True},
            'cpf': {'required': True},
            'nome': {'required': True},
        }

    def validate(self, data):
        if data['senha'] != data['confirmar_senha']:
            raise serializers.ValidationError("As senhas não coincidem.")
        if len(data['senha']) != 8 or not data['senha'].isdigit():
            raise serializers.ValidationError("A senha deve conter exatamente 8 dígitos numéricos.")
        if Usuario.objects.filter(cpf=data['cpf']).exists():
            raise serializers.ValidationError("Já existe um usuário com este CPF.")
        if Usuario.objects.filter(email=data['email']).exists():
            raise serializers.ValidationError("Já existe um usuário com este email.")
        return data

    def create(self, validated_data):
        validated_data.pop('confirmar_senha')
        senha = validated_data.pop('senha')
        
        user = Usuario(**validated_data)
        user.set_password(senha)  
        user.save()
        return user

class UsuarioLoginSerializer(serializers.Serializer):
    email = serializers.EmailField(required=True)
    senha = serializers.CharField(required=True, write_only=True)

    def validate(self, data):
        email = data.get('email')
        senha = data.get('senha')

        if not Usuario.objects.filter(email=email).exists():
            raise serializers.ValidationError("Usuário não encontrado.")

        usuario = Usuario.objects.get(email=email)
        if not usuario.check_password(senha):
            raise serializers.ValidationError("Senha incorreta.")

        return data
