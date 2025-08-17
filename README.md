# Dynamic PHP Shop Web Application

This repository contains a small PHP web application for **Moplin Ltd**, a local electronics shop.  It was developed as a personal learning project to demonstrates the principles of web application architecture using vanilla PHP, Twig templates, SCSS styling and PHPMailer.  The application is dynamic i.e. products, categories, greetings and the wishlist are generated on the fly from PHP data structures rather than being hard‑coded HTML files.

## Features

The application implements the following pages and behaviours:

| Page | Purpose |
|-----|--------|
| **Home** | Welcome page with an overview of the shop, a greeting (good morning/afternoon/evening) based on server time, an inline hero image and introductory text. |
| **Product List** | Dynamically lists all products with a thumbnail, name, category and price.  Clicking the product name or image shows more detail; clicking the category filters the list by that category. |
| **Product Details** | Shows a full‑size image with product name, description, category and price.  Includes an "Add to wishlist" button and a link back to the list. |
| **Wishlist** | Displays all products the user has added to their wishlist (stored in a PHP session).  Users can remove items or see a friendly message if the wishlist is empty. |
| **About Us** | Lists team members with photos and short biographies. |
| **Contact Us** | Shows Moplin’s address, phone number and opening hours.  Includes a contact form with name, email, type (general feedback or complaint) and message.  Submissions are sent via PHPMailer. |

Other key features include:

* **Dynamic data**: Product and category information are stored in multidimensional arrays in `includes/product_data.php`.  There is **no database** or CSV file; all data is defined in PHP.
* **Twig templating**: Views are built using Twig templates under `/templates` to separate presentation from logic.  Helpers such as `category_name()` and price formatting are registered in `includes/bootstrap.php`.
* **Wishlist state**: Uses PHP sessions (`\$_SESSION`) to persist the wishlist during the browser session.
* **SCSS styling**: Styles are written in SCSS (`public/scss/styles.scss`) and compiled to plain CSS (`public/css/styles.css`).  Colours and other theme values are defined in `public/scss/style-variables.scss` for easy customisation.
* **PHPMailer**: The contact form sends an email using PHPMailer.  SMTP credentials are kept out of the repository in a secret configuration file (`includes/mail_config.php`).

## Project Structure
```
├── public/ # Document root for the PHP built‑in server
│ ├── index.php # Home page controller
│ ├── product_list.php # Product list controller
│ ├── product_details.php # Product details controller
│ ├── wishlist.php # Wishlist controller
│ ├── about.php # About page controller
│ ├── contact.php # Contact form controller
│ ├── scss/ # Source SCSS files
│ │ ├── styles.scss
│ │ └── style-variables.scss
│ └── css/ # Compiled CSS (do not edit directly)
│ └── styles.css
├── templates/ # Twig templates
├── includes/
│ ├── bootstrap.php # Twig/environment setup and helper registration
│ ├── utils.php # Helper functions (e.g. category_name, price formatting)
│ ├── product_data.php # Arrays of products and categories
│ ├── mail_config.php.dist # Sample SMTP config (copy to mail_config.php)
│ └── mail_config.php # Local SMTP credentials (ignored by Git)
└── vendor/ # Composer dependencies (Twig, PHPMailer, etc.)
```


## Installation

### Prerequisites

* **PHP 8.1+** with the `pdo`, `session` and `openssl` extensions enabled.
* **Composer** to install PHP dependencies.
* **Node.js** and **npm** if you wish to compile SCSS; alternatively install the standalone [Dart Sass](https://sass-lang.com/dart-sass) CLI.

### Setup

1. **Clone the repository**:

   ```sh
   git clone https://github.com/NateFJF/DynamicPhp.git
   cd DynamicPhp
   ```

2. Install dependencies with Composer:

    ```sh
    composer install
    ```
    >This will install Twig and PHPMailer into the vendor/ directory.

3. Install SCSS compiler (optional but recommended):

The styles are written in SCSS and need to be compiled to CSS. You can either:

 - Install Dart Sass globally (recommended):
    
    ```sh
    npm install -g sass
    ```

- or using your package manager

    ```sh
    npm install
    npx sass public/scss/styles.scss public/css/styles.css
    ```
>Note: When developing, run Sass in watch mode so that any change to the SCSS will recompile automatically

```sh
sass --watch public/scss:public/css
```
4. Configure SMTP:

The contact form uses PHPMailer to send emails via SMTP. To keep credentials out of the repository, copy the provided template and fill in your own SMTP details:

```sh
cp includes/mail_config.php.dist includes/mail_config.php
# Edit includes/mail_config.php and replace the placeholders
```

You can use free SMTP providers like Gmail (requires two‑factor authentication and an app password), Outlook, or services such as Sendinblue/Brevo. For Gmail, set:

```php
return [
    'host'   => 'smtp.gmail.com',
    'user'   => 'youraddress@gmail.com',
    'pass'   => 'your_app_password',
    'secure' => PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS,
    'port'   => 587,
    'from'   => 'youraddress@gmail.com',
    'to'     => 'youraddress@gmail.com',
];
```

### Running the Application

You can run the application locally using PHP’s built‑in web server. Make sure you are in the project root (where public/ exists) and then run:

```sh
php -S localhost:8000 -t public
```
Open http://localhost:8000 in your browser. You should see the home page with the greeting and hero image. Navigate using the menu to see products, add to your wishlist, read about the team, and send messages via the contact form.

### Customisation

- Adding Products: Edit the $products array in includes/product_data.php. Each product entry includes a code, category code, name, description, image filename and price. Images must be placed in public/images/.

- Adding Categories: Edit the $categories array in the same file. Category codes must be unique and correspond to the category field of each product.

- Styling Colours: All colour values (navigation bar, headings, muted text, flash messages) are defined in public/scss/style-variables.scss. Adjust these variables to change the theme.

- Adding Team Members: Modify the $team array in public/about.php and provide new images in public/images/. The SCSS already constrains the team photos to reasonable sizes.

- Favicon: Place a favicon.png in public/images/ to have it automatically loaded on every page.

### Notes

- Sessions: The application uses PHP sessions to store the wishlist. Make sure your PHP installation is configured to support sessions and that cookies are enabled in your browser.

- Testing: It is recommended to test the application in at least two browsers (e.g. Chrome and Firefox) to ensure cross‑browser compatibility.

- Security: This project is intended for educational purposes and does not include full security hardening (e.g. CSRF tokens, input sanitisation beyond basic validation). Do not deploy it as‑is to production without further measures.

### License

This project is MIT. All third‑party libraries included via Composer (Twig, PHPMailer) are released under their respective open‑source licences. Images used are royalty‑free .