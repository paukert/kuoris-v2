# KUOris 2.0, bakalářská práce, FIT ČVUT

Text bakalářské práce je v samostatném repozitáři: https://github.com/paukert/fit-ctu-bachelors-thesis

## Požadavky
- stáhnout a nainstalovat [docker](https://www.docker.com/get-started) a [docker-compose](https://docs.docker.com/compose/)

## Konfigurace
- vytvořit a spustit kontejnery `docker-compose up -d --build`
- instalace závislostí (pomocí nástroje Composer) proběhne automaticky (v případě problémů lze spustit ručně pomocí `docker-compose exec php php composer install`)
- spuštění migrací proběhne také automaticky (v případě problémů lze spustit ručně pomocí `docker-compose exec php php bin/console doctrine:migrations:migrate`)
- testovací data lze vygenerovat pomocí `docker-compose exec php php bin/console doctrine:fixtures:load`
