# Viral Reflink App - MVC Boilerplate
MVC boilerplate to let you kickstart the development of a viral web application.
## Features
* Web content translation support
* User authentication
* Collecting points functionality based on the referral links
## Installation
1. Clone the repository to your webserver and install the dependencies.
2. Configure the database connection using the `.env` file.
3. Configure the .htaccess (or its equivalent if not using Apache) to route the
requests to the `/public` directory
4. Run the initial migration using `php migrations.php` command
## Initial database structure
The initial database consists of three tables:
- **migrations**: used by the app core to store data about performed migrations
- users: 
- refclick: stores data about every ref link click
## Routing
The app's router should be configured in `public/index.php`. Methods used for
routing are:

Router method | Description | Example
|---------|---------|---------|
`get($path, $callback)` | Defines a route for a request using the GET method | `$app->router->get('/contact', [ContactController::class, 'show']);`
`post($path, $callback)` | Defines a route for a request using the POST method | `$app->router->post('/contact', [ContactController::class, 'send']);`
`onErrors(array $errorCodes, $callback)` | Defines a route for specific HTTP error codes | `$app->router->onErrors([404], [ErrorsController::class, 'showNotFoundErrorPage']);`
`onErrorDefault($callback)` | Defines a route for any uncaught app error | `$app->router->onErrorDefault([ErrorsController::class, 'showDefaultErrorPage']);`
## Languages
App's language is defined in the `language` attribute of the 
`app\core\Application` object, which accepts only objects of the type of `app\core\Language`.
Please see the example `locales\Polish` for reference.
### Translating
Texts in the views should be put as a parameter of the helper function
`_($textToBeTranslated)` from `Helpers.php`.

 