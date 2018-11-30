# Spoon

Spoon is the Laravel template that is used for our projects that don't use [Blender](https://github.com/spatie/blender), which ships with big features like i18n and an admin panel. Spoon is relatively unopinionated, and comes with some utility packages we use in every project.

You may use our template but please notice that we offer no support whatsoever. We also don't
follow semver for this project and won't guarantee that the code (especially the master branch) is stable. In short: when using this, you're on your own.

## What's in the Box?

Some highlights of what's included here:

- Devtools: debugbar, laravel-mail-preview, laravel-tail
- Database backups
- Bugsnag integration
- PHP-CS fixer
- A zero-downtime deploy script with Envoy
- Our babel setup
- CSS transpilation with CSSNext

## Install

This guide assumes you're using [Laravel Valet](https://github.com/laravel/valet)

### Laravel App

Download the master branch

```bash
git clone https://github.com/spatie/spoon.git
```

Install the composer dependencies

```bash
composer install
```

Make a copy of the `.env.example` file

```bash
cp .env.example .env
```

Generate an application key

```bash
php artisan key:generate
```

Finally make sure you have a database named `spoon`, and run the migrations and seeds

```bash
php artisan migrate --seed
```

### Assets

Installing Spoon's front end dependencies requires `yarn`.

```bash
yarn
```

Spoon uses [Laravel Mix](https://laravel.com/docs/5.4/mix) to build assets.
To build assets run:

```bash
yarn run dev
```

Available build tasks are defined in `package.json`

## Colofon

### Contributing

Generally we won't accept any PR requests to Spoon. If you have discovered a bug or have an idea to improve the code, contact us first before you start coding.

### License

Spoon and The Laravel framework are open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
