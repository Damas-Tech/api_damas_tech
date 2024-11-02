from rest_framework import serializers
from .models import Usuario

class UsuarioSerializer(serializers.ModelSerializer):
    confirmar_senha = serializers.CharField(write_only=True)
    senha = serializers.CharField(source='password', write_only=True)  # Mapeia 'senha' para 'password'

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
        user = Usuario(
            nome=validated_data['nome'],
            sobrenome=validated_data['sobrenome'],
            cpf=validated_data['cpf'],
            email=validated_data['email']
        )
        user.set_password(validated_data['senha'])  # Use 'senha' aqui
        user.save()
        return user

class UsuarioLoginSerializer(serializers.Serializer):
    email = serializers.EmailField()
    senha = serializers.CharField(source='password')  # Mapeia 'senha' para 'password'

    def validate(self, data):
        return data
