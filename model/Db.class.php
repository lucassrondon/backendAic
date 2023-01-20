<?php

class DB {
    private static $writeDbConnection;
    private static $readDbConnection;

    protected static function connectWriteDb() 
    {
        $host = 'localhost';
        $port = '3306';
        $dbName = 'backend_aic';
        $username = 'root';
        $password = 'root';

        $dns = "mysql:host=$host;port=$port;dbname=$dbName";

        try 
        {
            if (!self::$writeDbConnection) 
            {
                self::$writeDbConnection = new PDO($dns, $username, $password);
                self::$writeDbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            return self::$writeDbConnection;
        }
        catch (PDOException $ex) 
        {
            $response = new Response();
            $response->setSuccess(false);
            $response->setHttpStatusCode(500);
            $response->addMessage('Algo deu errado - tente novamente');
            $response->send();
            exit;
        }
    }

    protected static function connectReadDb() 
    {
        $host = 'localhost';
        $port = '3306';
        $dbName = 'backend_aic';
        $username = 'root';
        $password = 'root';

        $dns = "mysql:host=$host;port=$port;dbname=$dbName";

        try 
        {
            if (!self::$readDbConnection) 
            {
                self::$readDbConnection = new PDO($dns, $username, $password);
                self::$readDbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            return self::$readDbConnection;
        }
        catch (PDOException $ex) 
        {
            $response = new Response();
            $response->setSuccess(false);
            $response->setHttpStatusCode(500);
            $response->addMessage('Algo deu errado - tente novamente');
            $response->send();
            exit;
        }
    }
}
