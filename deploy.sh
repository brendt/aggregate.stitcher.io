#!/bin/bash

. /home/forge/.bashrc
. ~/.nvm/nvm.sh

# Dependencies
php8.4 /usr/local/bin/composer install --no-dev
/home/forge/.bun/bin/bun --version
/home/forge/.bun/bin/bun install

# Tempest
php8.4 tempest cache:clear --force --internal --all
php8.4 tempest discovery:generate
php8.4 tempest migrate:up --force

# Build front-end
/home/forge/.bun/bin/bun run build
php8.4 tempest cache:clear --force

# Supervisor
sudo supervisorctl restart all
