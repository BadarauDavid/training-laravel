# Training-Laravel
## Project Description 
This project is centered around managing products and a shopping cart for an online shop. Below are the key features and functionalities:

## Database Structure

### Table: products
Fields: id (product ID), title, description, price, img_link
### Table: orders
Fields: id (product ID), creation_date, customer_contact, customer_comment, total

## File Structure
- index.php: Lists and fetches products that are not already in the cart.
- cart.php: Lists and fetches products that have been added to the cart.
- Product Images: Stored on the server HDD. Linked to products either via the product record ID in the filename or a specific field in the products table pointing to the image. Ensuring unique image names.


## Shopping Cart Management
- The cart is maintained as an array of product IDs (or IDs with quantities) in the Session.
- Only products not already in the cart are listed in index.php.
- cart.php displays products that have been added to the cart.

## Checkout Process

- The checkout button triggers the creation and sending of an HTML email.
- The email contains all information from cart.php, including product images.
- The email is sent to the shop manager's email, which is configured as a value.

## Technologies Used
- PHP
- Laravel
- MySQL


## Setup

- Clone this project
- npm install in console
- Start Apache and MySQL an acces http://localhost/index.php
