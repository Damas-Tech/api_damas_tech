from rest_framework import serializers
from .models import Empresa
from django.contrib.auth import authenticate

class EmpresaSerializer(serializers.ModelSerializer):
    confirmar_senha = serializers.CharField(write_only=True)

    class Meta:
        model = Empresa
        fields = ['id', 'nome', 'cnpj', 'email', 'senha', 'confirmar_senha']
        extra_kwargs = {
            'senha': {'write_only': True, 'min_length': 8},
            'email': {'required': True},
            'cnpj': {'required': True},
            'nome': {'required': True},
        }

    def validate(self, data):
        if data['senha'] != data['confirmar_senha']:
            raise serializers.ValidationError("As senhas não coincidem.")
    
        if Empresa.objects.filter(cnpj=data['cnpj']).exists():
            raise serializers.ValidationError("Já existe uma empresa com este CNPJ.")
        
        if Empresa.objects.filter(email=data['email']).exists():
            raise serializers.ValidationError("Já existe uma empresa com este email.")
        
        return data

    def create(self, validated_data):
        validated_data.pop('confirmar_senha')
        empresa = Empresa(
            nome=validated_data['nome'],
            razao_social=validated_data['razao_social'],
            cnpj=validated_data['cnpj'],
            email=validated_data['email']
        )
        empresa.set_password(validated_data['senha']) 
        empresa.save()
        return empresa


class LoginEmpresaSerializer(serializers.Serializer):
    email = serializers.EmailField()
    senha = serializers.CharField(write_only=True, max_length=8)

    def validate(self, data):
        email = data.get('email')
        senha = data.get('senha')

        empresa = Empresa.objects.filter(email=email).first()

        if empresa and empresa.check_password(senha):
            return data
        raise serializers.ValidationError("As credenciais estão incorretas.")
