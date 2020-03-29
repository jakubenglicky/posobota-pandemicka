Posobota s2e01 - pandemická
===========================

Jakub Englický - Vývojový stack v Dockeru
---------------------------- 

#### Postup spuštění

```
docker-compose up -d
```

 - nastartuje všechny potřebné kontejnery a nainstaluje se vendor/

``` 
docker-compose ps
```
 - lze zkontrolovat v jakém stavu jsou jednotlivé kontejnery
 
```
docker-compose logs -f #service#
# Pro opuštění CTRL + C
```

 - pohled na log konkrétního kontejneru
 
``` 
docker-compose run console es:fill-queue articles
```
 
 - naplní RabbitMQ frontu článkama k indexaci do ES
 
```
docker-compose -f docker-compose.yml -f docker-compose.consumers.yml up -d
```
 - zapne consumera pro zpracování fronty

---
 
##### Aplikace je dostupná na url: http://localhost:8080 

---
```
docker-compose down --remove-orphans
```

 - kompletně vypne a odstraní všechny kontejnery a smaže nepersistovaná data
 
---

Pokud se chci připojit do konkrétního kontejneru využiji:

```
docker-compose exec #service# bash
# Pro opuštění CTRL + A + D
```

- dobré, například pokud potřebuji nastavit práva složkám v kontejneru
```
docker-compose exec web chmod -R 0777 temp/ log/
```

--- 
Pro zjednodušení využívám v terminálu aliasy na jejich tvar se můžete podívat zde: https://gist.github.com/jakubenglicky/32b9b30af1236230c2d5bf9bbf3d6941