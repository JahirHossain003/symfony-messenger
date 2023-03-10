# Symfony Messenger!

### Setup
- install dev env https://devenv.sh/getting-started/
- Run `devenv up`. it will create the database.
- Add `DATABASE_URL="mysql://app:app@127.0.0.1:3306/app"` to .env file
- Login to shell `devenv shell`
- Then, create the database & tables!

```
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

** Fix yarn node js issue **

- Run `export NODE_OPTIONS=--openssl-legacy-provider`

**Compiling Webpack Encore Assets**

[yarn](https://yarnpkg.com). Then run:

```
yarn install
yarn encore dev
```

**Start the built-in web server**

```
symfony server:start -d
```

(If this is your first time using this command, you may see an
error that you need to run `symfony server:ca:install` first).

Now check out the site at `https://localhost:8000`

Have fun!

