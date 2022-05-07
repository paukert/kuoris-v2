# KUOris 2.0, bakalářská práce, FIT ČVUT

Text bakalářské práce je v samostatném repozitáři: https://github.com/paukert/fit-ctu-bachelors-thesis

## Požadavky
- stáhnout a nainstalovat [Docker](https://www.docker.com/get-started) a [Docker Compose](https://docs.docker.com/compose/)

## Konfigurace
- sestavit kontejnery příkazem `docker-compose build --pull --no-cache`
    - instalace závislostí pomocí balíčkovacího systému Composer proběhne automaticky (v případě potřeby lze spustit i pomocí `docker-compose exec php php composer install`)
- spustit kontejnery pomocí příkazu `docker-compose up -d`
    - databázové migrace se spustí také automaticky (případně je lze spustit i ručně pomocí `docker-compose exec php php bin/console doctrine:migrations:migrate`)
    - v rámci migrací bude do databáze vložen administrátor se jménem `KUO9801` a heslem `KUO9801` a i několik dat pro číselníky disciplín a úrovní
- testovací data obsahující další členy a události včetně přihlášek lze vygenerovat pomocí příkazu `docker-compose exec php php bin/console doctrine:fixtures:load --append`
- po provedení výše uvedených kroků bude systém dostupný na adrese `https://localhost/`
- všechny kontejnery lze naopak zastavit pomocí `docker-compose down --remove-orphans`
