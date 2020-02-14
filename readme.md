# PttEm Assignment

clone this project and go to directory run:

```bash
composer install
```

set mongo db eviroment in .env file:

```
MONGODB_URL=mongodb://localhost:27017
MONGODB_DB=pttem
```

run this command for generate dummy data:

```bash
php bin/console app:create-product
```

The Product ODM location is in src/Document/Product and Product ORM location is in Api/src/AppBundle/Entity/Product.

The tests are in test/ProductTest.php to run tests run:

```bash
./bin/phpunit
```

