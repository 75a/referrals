<?php

namespace app\core;

use app\core\db\Database;
use app\core\db\DbManager;
use app\models\User;

class Application
{
    public static string $ROOT_DIR;

    public string $layout = 'main';
    public Language $language;

    public Router $router;
    public Request $request;
    public Response $response;
    public Session $session;
    public Database $db;
    public ?User $user;

    public static Application $app;
    public ?Controller $controller = null;

    public function __construct($rootPath, array $config)
    {
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();
        $this->router = new Router($this->request, $this->response);

        $this->db = new Database($config['db']);

        $primaryValue = $this->session->get('user');
        if ($primaryValue !== ""){
            $primaryKey = (new User())->primaryKey();
            $this->user = DbManager::findOne(User::class, [$primaryKey => $primaryValue]);
        } else {
            $this->user = null;
        }
    }

    public function run(): void
    {
        try {
            echo $this->router->resolve();
        } catch (\Exception $e) {
            $httpCode = 404;
            if (is_int($e->getCode())) {
                $httpCode = $e->getCode();
            }
            $this->response->setStatusCode($httpCode);
            echo $this->router->resolveError($e);
        }
    }

    public function login(User $user): bool
    {
        $this->user = $user;
        $primaryKey = $user->primaryKey();
        $primaryValue = $user->{$primaryKey};
        $this->session->set('user', $primaryValue);
        return true;
    }

    public function logout(): void
    {
        $this->user = null;
        $this->session->remove('user');
    }

    public static function isGuest(): bool
    {
        return !self::$app->user;
    }
}