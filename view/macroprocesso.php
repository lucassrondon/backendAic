<?php

require_once('../model/Response.class.php');
require_once('../controller/MacroprocessoController.class.php');

if (empty($_GET))
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') 
    {
        $rawData = file_get_contents('php://input');

        if (!$bodyDataAsJsonObject = json_decode($rawData))
        {
            $response = new Response();
            $response->setSuccess(false);
            $response->setHttpStatusCode(400);
            $response->addMessage('O corpo da requisição não é um json válido');
            $response->send();
            exit;
        }

        if (!isset($bodyDataAsJsonObject->name))
        {
            $response = new Response();
            $response->setSuccess(false);
            $response->setHttpStatusCode(400);
            (!isset($bodyDataAsJsonObject->name) ? $response->addMessage('O campo name está faltando no json') : false);
            $response->send();
            exit;
        }

        $id = null;
        $name = $bodyDataAsJsonObject->name;
        $createdAt = time();
        $editedAt = null;

        try
        {
            $macroprocesso = new MacroprocessoController($id, $name, $createdAt, $editedAt);
        }
        catch (MacroProcessoException $ex)
        {
            $response = new Response();
            $response->setSuccess(false);
            $response->setHttpStatusCode(400);
            $response->addMessage($ex->getMessage());
            $response->send();
            exit;
        }

        if (!$createdMacroprocessoArray = $macroprocesso->createMacroprocesso()) 
        {
            $response = new Response();
            $response->setSuccess(false);
            $response->setHttpStatusCode(500);
            $response->addMessage('Algo deu errado - tente novamente');
            $response->send();
            exit;
        }

        $response = new Response();
        $response->setSuccess(true);
        $response->setHttpStatusCode(201);
        $response->addMessage('Macroprocesso criado');
        $response->setData($createdMacroprocessoArray);
        $response->send();
        exit;
    }
    elseif ($_SERVER['REQUEST_METHOD'] === 'GET')
    {
        $returnedMacroprocessoArrays = MacroprocessoController::getAllMacroprocessos();

        $response = new Response();
        $response->setSuccess(true);
        $response->setHttpStatusCode(200);
        $response->addMessage('Macroprocessos retornados');
        $response->setData($returnedMacroprocessoArrays);
        $response->send();
        exit;
    }
    else
    {
        $response = new Response();
        $response->setSuccess(false);
        $response->setHttpStatusCode(405);
        $response->addMessage('Método não permitido');
        $response->send();
        exit;
    }
}

elseif (array_key_exists('id', $_GET))
{
    $macroprocessoId = $_GET['id'];
    $name = null;
    $createdAt = null;
    $editedAt = null;

    try
    {
        $macroprocesso = new MacroprocessoController($macroprocessoId, $name, $createdAt, $editedAt);
    }
    catch (MacroProcessoException $ex)
    {
        $response = new Response();
        $response->setSuccess(false);
        $response->setHttpStatusCode(400);
        $response->addMessage($ex->getMessage());
        $response->send();
        exit;
    }

    if (!$returnedMacroprocessoArray = $macroprocesso->getMacroprocesso())
    {
        $response = new Response();
        $response->setSuccess(false);
        $response->setHttpStatusCode(404);
        $response->addMessage('Macroprocesso não encontrado');
        $response->send();
        exit;
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'GET') 
    {
        $response = new Response();
        $response->setSuccess(true);
        $response->setHttpStatusCode(200);
        $response->addMessage('Macroprocesso retornado');
        $response->setData($returnedMacroprocessoArray);
        $response->send();
        exit;
    }

    elseif ($_SERVER['REQUEST_METHOD'] === 'PUT')
    {
        $rawData = file_get_contents('php://input');

        if (!$bodyDataAsJsonObject = json_decode($rawData))
        {
            $response = new Response();
            $response->setSuccess(false);
            $response->setHttpStatusCode(400);
            $response->addMessage('O corpo da requisição não é do tipo json');
            $response->send();
            exit;
        }

        if (!isset($bodyDataAsJsonObject->name))
        {
            $response = new Response();
            $response->setSuccess(false);
            $response->setHttpStatusCode(400);
            $response->addMessage('Nenhum campo foi informado para atualização');
            $response->send();
            exit;
        }

        $newName = $bodyDataAsJsonObject->name;
        $currentName = $returnedMacroprocessoArray['name'];

        if ($newName === $currentName)
        {
            $response = new Response();
            $response->setSuccess(false);
            $response->setHttpStatusCode(400);
            $response->addMessage('Todos os valores dos campos informados para atualização são iguais aos valores atuais');
            $response->send();
            exit;
        }

        try
        {
            $macroprocesso->setName($newName);
            $macroprocesso->setEditedAt(time());
        }
        catch (MacroProcessoException $ex)
        {
            $response = new Response();
            $response->setSuccess(false);
            $response->setHttpStatusCode(400);
            $response->addMessage($ex->getMessage());
            $response->send();
            exit;
        }

        if (!$updatedMacroprocessoArray = $macroprocesso->updateMacroprocesso())
        {
            $response = new Response();
            $response->setSuccess(false);
            $response->setHttpStatusCode(500);
            $response->addMessage('Algo deu errado - tente novamente');
            $response->send();
            exit;
        }

        $response = new Response();
        $response->setSuccess(true);
        $response->setHttpStatusCode(200);
        $response->addMessage('Macroprocesso atualizado');
        $response->setData($updatedMacroprocessoArray);
        $response->send();
        exit;
    }

    elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE')
    {
        if (!$macroprocesso->deleteMacroprocesso())
        {
            $response = new Response();
            $response->setSuccess(false);
            $response->setHttpStatusCode(500);
            $response->addMessage('Algo deu errado - tente novamente');
            $response->send();
            exit;
        }

        $response = new Response();
        $response->setSuccess(true);
        $response->setHttpStatusCode(200);
        $response->addMessage('Macroprocesso deletado');
        $response->setData($returnedMacroprocessoArray);
        $response->send();
        exit;
    }

    else
    {
        $response = new Response();
        $response->setSuccess(false);
        $response->setHttpStatusCode(405);
        $response->addMessage('Método não permitido');
        $response->send();
        exit;
    }
}

else
{
    $response = new Response();
    $response->setSuccess(false);
    $response->setHttpStatusCode(404);
    $response->addMessage('Endpoint não encontrado');
    $response->send();
    exit;
}

