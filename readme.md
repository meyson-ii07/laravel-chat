
**Вимоги**

1. Мінімальна версія php 7.1
2. MySQL 5.7
3. Composer
4. Yarn

**Розгортання проекту:**

1. Стягнути репозиторій
2. Внести дані в .env файл
    BROADCAST_DRIVER=pusher
    
    PUSHER_APP_ID=21213
    PUSHER_APP_KEY=DWADAAW
    PUSHER_APP_SECRET=AWDAAAS
    PUSHER_APP_CLUSTER=mt1
3. Composer update
4. yarn install 
5. yarn dev
6. Внести дані доступу до БД в .env файл 
7. php artisan migrate
  
запустити сервери

```
 php artisan serve
 php artisan websockets:serve
```
