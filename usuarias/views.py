from rest_framework import generics, status
from .serializers import UsuarioSerializer, UsuarioLoginSerializer
from .models import Usuario
from rest_framework.response import Response
from django.contrib.auth import authenticate

class UsuarioCreateView(generics.CreateAPIView):
    serializer_class = UsuarioSerializer

class UsuarioLoginView(generics.GenericAPIView):
    serializer_class = UsuarioLoginSerializer

    def post(self, request, *args, **kwargs):
        serializer = self.get_serializer(data=request.data)
        serializer.is_valid(raise_exception=True)
        email = serializer.validated_data['email']
        senha = serializer.validated_data['senha']
        
        # Corrigir a chamada de authenticate para usar 'username' em vez de 'email' e 'senha'
        usuario = authenticate(username=email, password=senha)
        
        if usuario is not None:
            # Login bem-sucedido
            return Response({'message': 'Login bem-sucedido'}, status=status.HTTP_200_OK)
        else:
            return Response({'error': 'Credenciais inválidas'}, status=status.HTTP_401_UNAUTHORIZED)
