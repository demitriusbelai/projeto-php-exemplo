Para funcionar no EasyPHP:
 - php.ini:
	* Habilitar o short_open_tag
	* Habilitar a extensão php_pdo_mysql.dll

 - httpd.conf:
	* Habilitar mod_rewrite
	* Habilitar "AllowOverride All" para o diretório.

 - criar o banco e importar o arquivo config/ecommerce.sql
 - editar a conexão no arquivo config/config.php

O login para a área administrativa é:
	Usuário:	admin
	Senha:		admin123
