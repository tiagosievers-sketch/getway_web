# 2easy-ede-gateway - Script de instalação e execução
# Executa as etapas do README e abre a aplicação no navegador

$ErrorActionPreference = "Stop"
$ProjectRoot = $PSScriptRoot
Set-Location $ProjectRoot

Write-Host "=== 2easy-ede-gateway - Instalação e execução ===" -ForegroundColor Cyan
Write-Host ""

# 1. Verificar Docker
Write-Host "[1/7] Verificando Docker..." -ForegroundColor Yellow
$dockerOk = $false
& docker ps 2>$null | Out-Null
if ($LASTEXITCODE -eq 0) { $dockerOk = $true }
if (-not $dockerOk) {
    Write-Host "ERRO: Docker nao esta rodando ou nao esta instalado. Inicie o Docker Desktop e tente novamente." -ForegroundColor Red
    exit 1
}
Write-Host "    Docker OK." -ForegroundColor Green

# 2. Garantir .env
if (-not (Test-Path ".env")) {
    Write-Host "[2/7] Arquivo .env nao encontrado. Copiando .env.example para .env..." -ForegroundColor Yellow
    Copy-Item ".env.example" ".env"
    Write-Host "    Ajuste DB_HOST e APP_URL no .env se usar docker-compose-dev.yml" -ForegroundColor Gray
} else {
    Write-Host "[2/7] .env encontrado." -ForegroundColor Green
}

# 3. Subir containers (ambiente dev com MySQL)
Write-Host "[3/7] Subindo containers (docker-compose-dev: gateway + MySQL)..." -ForegroundColor Yellow
& docker-compose -f docker-compose-dev.yml up -d --build
if ($LASTEXITCODE -ne 0) {
    Write-Host "ERRO ao subir containers." -ForegroundColor Red
    exit 1
}
Write-Host "    Containers em execucao." -ForegroundColor Green

# 4. Aguardar MySQL ficar pronto
Write-Host "[4/7] Aguardando MySQL ficar pronto (~30s)..." -ForegroundColor Yellow
Start-Sleep -Seconds 25
$maxAttempts = 10
$ready = $false
for ($i = 1; $i -le $maxAttempts; $i++) {
    $ErrorActionPreference = "SilentlyContinue"
    $null = docker exec mysql-gateway mysql -h localhost -u root -p2easy_2024 -e "SELECT 1;" 2>$null
    $ErrorActionPreference = "Stop"
    if ($LASTEXITCODE -eq 0) { $ready = $true; break }
    Start-Sleep -Seconds 2
}
if (-not $ready) {
    Write-Host "    Aviso: MySQL pode ainda estar iniciando. Continuando..." -ForegroundColor Yellow
} else {
    Write-Host "    MySQL pronto." -ForegroundColor Green
}

# 5. Composer install no container
Write-Host "[5/7] Instalando dependencias PHP (composer install) no container..." -ForegroundColor Yellow
& docker exec 2easy-ede-gateway composer install --ignore-platform-reqs --no-interaction
if ($LASTEXITCODE -ne 0) {
    Write-Host "ERRO no composer install." -ForegroundColor Red
    exit 1
}
Write-Host "    Composer OK." -ForegroundColor Green

# 6. NPM install e build (local)
Write-Host "[6/7] Instalando dependencias JS e build (npm install + npm run build)..." -ForegroundColor Yellow
& npm install
if ($LASTEXITCODE -ne 0) {
    Write-Host "ERRO no npm install." -ForegroundColor Red
    exit 1
}
& npm run build
if ($LASTEXITCODE -ne 0) {
    Write-Host "Aviso: npm run build falhou (pode ser normal se nao houver frontend). Continuando..." -ForegroundColor Yellow
} else {
    Write-Host "    NPM OK." -ForegroundColor Green
}

# 7. Migrations
Write-Host "[7/7] Executando migrations..." -ForegroundColor Yellow
& docker exec 2easy-ede-gateway php artisan migrate --force
if ($LASTEXITCODE -ne 0) {
    Write-Host "Aviso: migrate falhou. Verifique o banco e .env (DB_HOST=mysql-gateway)." -ForegroundColor Yellow
} else {
    Write-Host "    Migrations OK." -ForegroundColor Green
}

Write-Host ""
Write-Host "=== Aplicacao disponivel em http://localhost:27001 ===" -ForegroundColor Cyan
Write-Host "Abrindo no navegador..." -ForegroundColor Gray
Start-Process "http://localhost:27001"

Write-Host ""
Write-Host "Para parar: docker-compose -f docker-compose-dev.yml down" -ForegroundColor Gray
