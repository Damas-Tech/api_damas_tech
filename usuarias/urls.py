from django.urls import path
from .views import UsuarioCreateView, UsuarioLoginView

urlpatterns = [
    path('cadastrar/', UsuarioCreateView.as_view(), name='cadastrar_usuario'),
    path('login/', UsuarioLoginView.as_view(), name='login_usuario'),
]

