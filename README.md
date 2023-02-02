# Setup up the backend

 - cd backend
 - docker network create pinia-plugin-persistedstate-reproduce
 - docker-compose up -d
 - docker exec -it pinia-plugin-persistedstate-reproduce-api composer install
 - docker exec -it pinia-plugin-persistedstate-reproduce-api php artisan migrate
 - docker exec -it pinia-plugin-persistedstate-reproduce-api php artisan db:seed
 - docker exec -it pinia-plugin-persistedstate-reproduce-api /app/vendor/phpunit/phpunit/phpunit /app/tests
 - Visit http://localhost to see that backend works and see the documentation. 
 
There should only login, refresh and couple of test entities

# Setup up the frontend

 - cd ../frontend
 - docker-compose up --build

# Steps to reproduce the problem

1. Visit http://localhost:3000
2. Enter credentials:  
  Login: admin@admin.com  
  Password: 123  
3. There is two pages of entities loaded from API. It is needed to check that navigation between pages and refreshing
the token on the client side works as expected. You can navigate between these two pages as much time as you want. 
Also, you can refresh page and while there is no refresh token on the server side everything works wine
4. Wait a minute without any action
5. Refresh page
6. Now you see that we can not fetch entities anymore because on the client side there is an old token but we already
refreshed it on the server side.