from django.urls import path
from .views import UsuarioCreateView, UsuarioLoginView

urlpatterns = [
    path('cadastro/', UsuarioCreateView.as_view(), name='usuario_create'),
    path('login/', UsuarioLoginView.as_view(), name='usuario_login'),
]
