<?php

namespace HelloFresh\Recipe\Authenticator;

use Symfony\Component\HttpFoundation\Request;

class Auth
{
    /**
     * @author Arotimi Busayo <arotimi.busayo@gmail.com>
     *
     * @param Request $request
     */
    public static function secureBasic(Request $request)
    {
        $username = $request->server->get('PHP_AUTH_USER');
        $password = $request->server->get('PHP_AUTH_PW');

        if ($username && $password) {
            $credentials = self::getAuthCredsFromFile();
            if (! ($username == $credentials['username'] && $password == $credentials['password'])) {
                self::promptBasicLogin("Invalid username and password");
            }
        } else {
            self::promptBasicLogin("Please Login to access this resource");
        }
    }

    /**
     * @author Arotimi Busayo <arotimi.busayo@gmail.com>
     *
     * @param $message
     */
    private static function promptBasicLogin($message)
    {
        header("WWW-Authenticate: Basic realm=\"{$message}\"");
        header("HTTP/1.0 401 Unauthorized");
    }

    /**
     * @author Arotimi Busayo <arotimi.busayo@gmail.com>
     *
     * @return mixed
     */
    private static function getAuthCredsFromFile()
    {
        return (include __DIR__.'/../../config.php')['auth_credentials'];
    }
}
