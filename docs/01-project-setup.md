# 01. Project Setup

This project is a modern Laravel application, 
with some minor changes to the default Laravel setup.

## Project structure

Instead of the usual `\App` root namespace, there are three in this project:

- `\App`: for all application code: HTTP controllers, Console apps,…
- `\Domain`: for all domain-related code: models, actions,…
- `\Support`: for standalone support classes or modules.

## Seeding data

Seeders are disabled in this project, 
you should use the `playbook:run` command to fill your database with dummy data.
`migrate` and `db:seed` commands won't work.

You can run a playbook like so:

```bash
artisan playbook:run {playbook} [--clean]
```

The `{playbook}` argument should be the name of the class found in 
`\App\Console\Playbooks`. For example:

```bash
artisan playbook:run PostsPlaybook --clean
```

The `--clean` flag will migrate a fresh database.
