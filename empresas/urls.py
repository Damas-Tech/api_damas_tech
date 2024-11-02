from django.urls import path
from .views import EmpresaCreateView, LoginView

urlpatterns = [
    path('cadastro/', EmpresaCreateView.as_view(), name='empresa-cadastro'),  # Mudei de 'empresas/' para 'cadastro/'
    path('login/', LoginView.as_view(), name='empresa-login'),  # Mudei de 'empresas/login/' para 'login/'
]
