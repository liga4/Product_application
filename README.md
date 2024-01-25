# Product Managament Application

This effective application allows users to effortlessly view, add by their types, and delete products. 

## Features

- **Create Products**
- **View Products**
- **Delete Products**

## To run Product Managment application in your server, you'll need 

#### PHP (version 7.4 or higher)
#### Composer
#### MySQL or a database of your choice

1. **Clone the repository**:
    - Git clone ..

2. **Install Dependencies**:
    - composer install

3. **Set up environment**:
    - set up .env (recreate .env.example and add your database information)

4. **Setup database**:
    - set up database **products**, create table **products** with columns:
      - **id** (INT (auto increment), primary key)
      - **name** (VARCHAR(255))
      - **sku** (VARCHAR(255))
      - **price** (INT)
      - **product_type** (VARCHAR(255))
      - **size** (INT)
      - **weight** (INT)
      - **height** (INT)
      - **width** (INT)
      - **length** (INT)
        
5. **Start application**:
    - cd public
    - php -S localhost:8000
  
