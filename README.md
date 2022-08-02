# Figured Assessment

A Laravel application that helps a user understand how much quantity of a product is available for use.

## Specs
Laravel Framework 8.83.23<br>
PHP 7.3 or above

### Application Setup
``` bash
# Clone repository from https://github.com/gerardreyes/figured_assessment_gerard_reyes.
HTTPS: https://github.com/gerardreyes/figured_assessment_gerard_reyes.git
SSH: git@github.com:gerardreyes/figured_assessment_gerard_reyes.git

# Go inside the folder.
cd figured_assessment_gerard_reyes

# Create your own .env file. Set your DB_DATABASE, DB_USERNAME, DB_PASSWORD.
cp .env.example .env

# Run Composer Install.
composer install

# Serve the project.
php artisan serve

# If you are using Laravel Valet, park the directory.
valet park

# If you would like to serve a site over encrypted TLS using HTTP/2, run secure.
valet secure figured_assessment_gerard_reyes

```

### Database Setup
``` bash
# Run migration to create the inventories table.
php artisan migrate

# Run seeder to populate the inventories table.
php artisan db:seed
```

### Application Run
Open your browser and go to: 
```
https://figured_assessment_gerard_reyes.test/
```

## Code Overview
> The application should display an interface with a button and a single input that represents the requested quantity of a product.
> When the button is clicked, the interface should show either the $ value of the quantity of that product that will be applied, or an error message if the quantity to be applied exceeds the quantity on hand.
> Note that product purchased first should be used first, therefore the quantity on hand should be the most recently purchased.

> Here is a small example of inventory movements:
> a. Purchased 1 unit at $10 per unit
> b. Purchased 2 units at $20 per unit
> c. Purchased 2 units at $15 per unit
> d. Applied 2 units 

> After the 2 units have been applied, the purchased units in 'a' have been completely used up. Only 1 unit from 'b' has been used, so the remaining inventory looks like this:
> b. 1 unit at $20 per unit c. 2 units at $15 per unit
> Quantity on hand = 3 Valuation = (1 * 20) + (2 * 15) = $50
## Testing
Run command below to execute tests:
```
php artisan test
```

## Project Details
Feel free to email gerardreyes112@gmail.com for any inquiries regarding this project.

## License
https://github.com/gerardreyes