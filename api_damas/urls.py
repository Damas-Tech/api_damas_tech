from django.contrib import admin
from django.urls import path, include
from rest_framework import permissions
from drf_yasg.views import get_schema_view
from drf_yasg import openapi

schema_view = get_schema_view(
    openapi.Info(
        title="API Damas Tech",
        default_version='v1',
        description="Documentação da API Damas Tech",
        terms_of_service="https://www.google.com/policies/terms/",
        contact=openapi.Contact(email="contact@damastech.local"),
        license=openapi.License(name="Licença BSD"),
    ),
    public=True,
    permission_classes=(permissions.AllowAny,),
)

urlpatterns = [
    path('admin/', admin.site.urls),
    path('usuarias/', include('usuarias.urls')),  # Verifique se esta linha está correta
    path('empresas/', include('empresas.urls')),
    path('swagger/', schema_view.with_ui('swagger', cache_timeout=0), name='schema-swagger-ui'),
    path('redoc/', schema_view.with_ui('redoc', cache_timeout=0), name='schema-redoc'),
]
