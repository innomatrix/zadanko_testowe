# zadanko_testowe
zadanko testowe -> WebMakers


API Gmaps działa tylko z domeną lokalna na HTTPS (geolokalizacja): https://test.test

Git clone a następnie:

1. composer install
2. yarn install 
3. yarn build
3. ./bin/console doctrine:database:create ||  php bin/console doctrine:database:create
4. ./bin/console doctrine:migrations:migrate || php bin/console doctrine:migrations:migrate
