# number-api-demo

1. cloner le repo
2. cd number-api-demo
3. composer install
4. modifier le bas du .env "DATABASE_URL" et remplacer "root:" par votre user/mot de passe pour la db
5. php bin/console doctrine:database:create
6. php bin/console doctrine:schema:update --force
7. php bin/console server:run
8. aller sur 127.0.0.1:8000/api
9. commencer a ajouter des listes
