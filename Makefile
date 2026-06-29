RED=\033[31m
GREEN=\033[32m
YELLOW=\033[33m
RESET=\033[0m

setup:
	@echo "$(YELLOW)Creating container network...$(RESET)"
	@docker network create --driver bridge app-network || true
	@echo "$(YELLOW)Preparing directories...$(RESET)"
	@mkdir -p storage/framework/sessions storage/framework/views storage/framework/cache
	@mkdir -p storage/logs/laravel storage/logs/nginx
	@mkdir -p bootstrap/cache
	@echo "$(YELLOW)Building containers...$(RESET)"
	@docker compose up -d --build
	@echo "$(YELLOW)Fixing ownership and permissions...$(RESET)"
	@docker compose exec -u root app chown -R tecsa:tecsa /var/www/html
	@docker compose exec -u root app chmod -R 775 storage bootstrap/cache
	@docker compose exec -u root app chmod -R 777 storage/logs storage/framework
	@echo "$(YELLOW)Installing backend dependencies...$(RESET)"
	@docker compose exec app composer install
	@echo "$(YELLOW)Generating app key...$(RESET)"
	@docker compose exec app php artisan key:generate --ansi
	@echo "$(YELLOW)Creating storage link...$(RESET)"
	@docker compose exec app php artisan storage:link || true
	@echo "$(YELLOW)Setting up database...$(RESET)"
	@${MAKE} migrate
	@echo "$(GREEN)Setup completed successfully!$(RESET)"

build:
	@echo "$(YELLOW)Creating container network...$(RESET)"
	@docker network create --driver bridge app-network || true
	@echo "$(YELLOW)Preparing directories...$(RESET)"
	@mkdir -p storage/framework/sessions storage/framework/views storage/framework/cache
	@mkdir -p storage/logs/laravel storage/logs/nginx
	@mkdir -p bootstrap/cache
	@echo "$(YELLOW)Building containers...$(RESET)"
	@docker compose up -d --build
	@echo "$(YELLOW)Fixing ownership and permissions...$(RESET)"
	@docker compose exec -u root app chown -R tecsa:tecsa /var/www/html
	@docker compose exec -u root app chmod -R 775 storage bootstrap/cache
	@docker compose exec -u root app chmod -R 777 storage/logs storage/framework
	@echo "$(YELLOW)Installing backend dependencies...$(RESET)"
	@docker compose exec app composer install --no-dev --no-progress -a
	@echo "$(YELLOW)Generating app key...$(RESET)"
	@docker compose exec app php artisan key:generate --ansi
	@echo "$(YELLOW)Optimizing app...$(RESET)"
	@docker compose exec app php artisan optimize
	@echo "$(YELLOW)Updating database...$(RESET)"
	@docker compose exec app php artisan migrate
	@echo "$(YELLOW)Creating storage link...$(RESET)"
	@docker compose exec app php artisan storage:link || true
	@${MAKE} clear-config
	@echo "$(GREEN)Build completed successfully!$(RESET)"

up start:
	@echo "$(YELLOW)Starting containers...$(RESET)"
	@docker compose up -d

stop:
	@echo "$(YELLOW)Stopping containers...$(RESET)"
	@docker compose stop

down:
	@echo "$(YELLOW)Stopping containers [DOWN]...$(RESET)"
	@docker compose down -v

ps status:
	@echo "$(YELLOW)Containers:$(RESET)"
	@docker compose ps

restart:
	@echo "$(YELLOW)Restarting containers...$(RESET)"
	@docker compose restart

migrate:
	@echo "$(YELLOW)Setting up database...$(RESET)"
	@docker compose exec app php artisan migrate:refresh --seed

test:
	@echo "$(YELLOW)Running tests...$(RESET)"
	@docker compose exec app php artisan test

clear-logs:
	@echo "$(YELLOW)Clearing logs...$(RESET)"
	@docker compose exec -u root app rm -rf storage/logs/*.log
	@docker compose exec -u root app mkdir -p storage/logs/nginx storage/logs/laravel
	@docker compose exec -u root app chown -R tecsa:tecsa storage/logs
	@docker compose exec -u root app chmod -R 777 storage/logs

clear-config:
	@echo "$(YELLOW)Clearing config cache...$(RESET)"
	@docker compose exec app php artisan config:clear
	@docker compose exec app php artisan config:cache
