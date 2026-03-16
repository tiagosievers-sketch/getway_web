## Especificações
* PHP 8.2
* Laravel 11

### Instalação em ambiente de desenvolvimento:

#### Opção rápida (autorun)
* Tenha o **Docker Desktop** instalado e em execução.
* No PowerShell, na pasta do projeto, execute:
```
.\autorun.ps1
```
O script sobe os containers (gateway + MySQL), instala dependências (composer + npm), roda as migrations e abre a aplicação em http://localhost:27001.

#### Instalação manual
* Instalar Chocolatey rodando o comando abaixo em uma shell com administrador
```
Set-ExecutionPolicy Bypass -Scope Process -Force; [System.Net.ServicePointManager]::SecurityProtocol = [System.Net.ServicePointManager]::SecurityProtocol -bor 3072; iex ((New-Object System.Net.WebClient).DownloadString('https://community.chocolatey.org/install.ps1'))
```
* Instalar Make for windows
```
choco install make
```
* Criar e configurar .env para corresponder ao banco mysql descrito no docker-compose
* Executar
```
docker-compose up
```
ou
```
make build
```
* Caso seja necessário executar:
```
docker exec 2easy-ede-web-backend composer install  --ignore-platform-reqs
```
ou
```
make laravel-install
```

### MIGRATIONS

* Rodar Migrations (Especificamos uma database "diferente" para contornar um problema de configuração devido a nomenclaturas de tabela em caixa alta)
```
docker exec 2easy-ede-web-backend php artisan migrate
```
ou
```
make laravel-migrate
```

### INICIALIZAÇÂO / ATUALIZAÇÃO DA BASE DE DADOS

* Inicia e/ou atualiza a base de dados executando as migrations e as seeds
```
docker exec 2easy-ede-web-backend php artisan migrate:refresh --seed
```
ou
```
make laravel-seed
```

### SCHEDULER
* É necessário configurar um cron job nas entradas de configuração do servidor para que o comando </br>
abaixo seja rodado a cada minuto
```
php artisan schedule:run
``` 
* Com crontab o comando seria o seguinte:
```
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```
### Instalação em ambiente de produção:
* Se o banco já estiver configurado faça apenas:
```
docker exec 2easy-ede-gateway composer install
npm install
npm run build
```
Isso deve instalar a base necessária para a aplicação funcionar no container

<h3 align="left">Linguagens e Ferramentas:</h3>
<p align="center"> 
<a href="https://www.docker.com/" target="_blank" rel="noreferrer"> <img    src="https://raw.githubusercontent.com/devicons/devicon/master/icons/docker/docker-original-wordmark.svg" alt="docker" width="40" height="40"/> </a> 
<a href="https://git-scm.com/" target="_blank" rel="noreferrer"> <img src="https://www.vectorlogo.zone/logos/git-scm/git-scm-icon.svg" alt="git" width="40" height="40"/> </a> 
<a href="https://laravel.com/" target="_blank" rel="noreferrer"> <img src="https://raw.githubusercontent.com/devicons/devicon/master/icons/laravel/laravel-plain-wordmark.svg" alt="laravel" width="40" height="40"/> </a> 
<a href="https://www.linux.org/" target="_blank" rel="noreferrer"> <img src="https://raw.githubusercontent.com/devicons/devicon/master/icons/linux/linux-original.svg" alt="linux" width="40" height="40"/> </a> 
<a href="https://www.nginx.com" target="_blank" rel="noreferrer"> <img src="https://raw.githubusercontent.com/devicons/devicon/master/icons/nginx/nginx-original.svg" alt="nginx" width="40" height="40"/> </a>  
<a href="https://www.php.net" target="_blank" rel="noreferrer"> <img src="https://raw.githubusercontent.com/devicons/devicon/master/icons/php/php-original.svg" alt="php" width="40" height="40"/> </a> 
</p>

