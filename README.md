[![Docker](https://img.shields.io/badge/Docker-2496ED?logo=docker&logoColor=white)](https://www.docker.com/)
[![PHP](https://img.shields.io/badge/PHP-8.4-777BB4?logo=php&logoColor=white)](https://www.php.net/)
[![Laravel](https://img.shields.io/badge/Laravel-13.17-FF2D20?logo=laravel&logoColor=white)](https://laravel.com/)
[![PostgreSQL](https://img.shields.io/badge/PostgreSQL-15-4169E1?logo=postgresql&logoColor=white)](https://www.postgresql.org/)

## Antes de instalar
Certifique-se de que você tenha o Docker. Caso não tenha, siga o guia <a href="https://www.docker.com/get-started" target="_blank">Primeiros passos com o Docker</a>.

O projeto conta com alguns comandos que ajudam a simplificar e agilizar o setup. Caso queira utilizá-los, é necessário ter o **Make** instalado no sistema.

**Para Windows:**
- Instale o [Chocolatey](https://chocolatey.org/install) e rode:
  ```
  choco install make
  ```
- Ou Instale diretamente o [GnuWin32](http://gnuwin32.sourceforge.net/packages/make.htm)

**Para macOS:**
- Instale via Homebrew:
  ```
  brew install make
  ```
- Ou instale as Ferramentas de Linha de Comando do Xcode:
  ```
  xcode-select --install
  ```

**Para Linux:**
- Debian/Ubuntu
  ```
  sudo apt-get install make
  ```
- Red Hat/CentOS
  ```
  sudo yum install make
  ```

## Guia de Instalação

#### Clone o repositório:
```
git clone https://github.com/GiovaniAppezzato/health-dashboard-backend
```

#### Copiar .env
```
cp .env.example .env
```
<sup>Verifique se não há nenhum serviço utilizando as mesmas portas em sua máquina. Caso exista, ajuste elas dentro do arquivo.</sup>

#### Setup com Make
```
make setup
```
<sup>Este comando deve ser usado apenas em ambiente de desenvolvimento. Para produção, utilize o comando ```build```.</sup>

#### Setup sem o Make
<sup>Nesse caso, será necessário executar todos os comandos manualmente, na seguinte sequência:</sup>
```
docker compose up -d --build

docker compose exec app bash

composer install

php artisan key:generate --ansi

php artisan storage:link

php artisan migrate
```

**Tudo pronto!** 🎉  
A aplicação estará disponível em: http://localhost:9000

## Integração com OpenAI

Este projeto utiliza a OpenAI para gerar recomendações personalizadas a partir dos biomarcadores informados pelo usuário.

Para que essa funcionalidade funcione corretamente, preencha as variáveis abaixo no arquivo `.env`:

```
OPENAI_API_KEY=
OPENAI_ORGANIZATION=
OPENAI_MODEL=gpt-4o-mini
```

O campo `OPENAI_API_KEY` é obrigatório para a geração das recomendações via IA. O campo `OPENAI_ORGANIZATION` é opcional e pode ficar vazio caso sua conta não utilize organização.

## Execução dos testes

Certifique-se que a aplicação esteja rodando corretamente e rode:

```
make test
```
Ou, alternativamente, execute dentro do container:
```
php artisan test
```

<div align="center">
  Feito com ♡ por <a href="https://www.linkedin.com/in/giovani-appezzato">Giovani Appezzato</a><br>
    <b>Por favor, mantenha o código limpo e organizado. Obrigado!</b>
</div>
