# Generated by Django 5.1.2 on 2024-11-02 00:55

from django.db import migrations, models


class Migration(migrations.Migration):

    dependencies = [
        ('usuarias', '0002_alter_usuario_options_alter_usuario_managers_and_more'),
    ]

    operations = [
        migrations.AddField(
            model_name='usuario',
            name='is_staff',
            field=models.BooleanField(default=False),
        ),
    ]