<?php

require_once('Db.class.php');

class MacroprocessoModel extends DB 
{
    protected function createMacroprocessoInDatabase($name, $createdAt)
    {
        try
        {
            $writeDb = DB::connectWriteDb();

            $writeDb->beginTransaction();

            $query = $writeDb->prepare('insert into macroprocesso (name, createdAt) values (:name, FROM_UNIXTIME(:createdAt))');
            $query->bindParam(':name', $name, PDO::PARAM_STR);
            $query->bindParam(':createdAt', $createdAt, PDO::PARAM_INT);
            $query->execute();

            $lastInsertedId = $writeDb->lastInsertId();

            if (!$macroprocessoArray = $this->getMacroprocessoInDatabase($lastInsertedId))
            {
                if ($writeDb->inTransaction())
                {
                $writeDb->rollBack();
                }
                return false;
            }

            $writeDb->commit();

            return $macroprocessoArray;
        }
        catch (PDOException $ex)
        {
            if ($writeDb->inTransaction())
            {
                $writeDb->rollBack();
            }
            $response = new Response();
            $response->setSuccess(false);
            $response->setHttpStatusCode(500);
            $response->addMessage('Algo deu errado - tente novamente');
            $response->send();
            exit;
        }
    }

    protected function getMacroprocessoInDatabase($macroprocessoId)
    {
        try
        {
            $writeDb = DB::connectWriteDb();

            $query = $writeDb->prepare('select * from macroprocesso where id=:macroprocessoId');
            $query->bindParam(':macroprocessoId', $macroprocessoId, PDO::PARAM_INT);
            $query->execute();

            $rowCount = $query->rowCount();

            if ($rowCount == 0)
            {
                return false;
            }

            return $query->fetch(PDO::FETCH_ASSOC);
        }
        catch (PDOException $ex)
        {
            if ($writeDb->inTransaction())
            {
                $writeDb->rollBack();
            }
            $response = new Response();
            $response->setSuccess(false);
            $response->setHttpStatusCode(500);
            $response->addMessage('Algo deu errado - tente novamente');
            $response->send();
            exit;
        }
    }

    protected function deleteMacroprocessoInDatabase($macroprocessoId)
    {
        try
        {
            $writeDb = DB::connectWriteDb();

            $query = $writeDb->prepare('delete from macroprocesso where id=:macroprocessoId');
            $query->bindParam(':macroprocessoId', $macroprocessoId, PDO::PARAM_INT);
            $query->execute();

            $rowCount = $query->rowCount();

            if ($rowCount == 0)
            {
                return false;
            }

            return true;
        }
        catch (PDOException $ex)
        {
            if ($writeDb->inTransaction())
            {
                $writeDb->rollBack();
            }
            $response = new Response();
            $response->setSuccess(false);
            $response->setHttpStatusCode(500);
            $response->addMessage('Algo deu errado - tente novamente');
            $response->send();
            exit;
        }
    }

    protected function updateMacroprocessoInDatabase($macroprocessoId, $name, $editedAt)
    {
        try
        {
            $writeDb = DB::connectWriteDb();

            $writeDb->beginTransaction();

            $query = $writeDb->prepare('update macroprocesso set name=:newName, editedAt=FROM_UNIXTIME(:editedAt) where id=:macroprocessoId');
            $query->bindParam(':macroprocessoId', $macroprocessoId, PDO::PARAM_INT);
            $query->bindParam(':newName', $name, PDO::PARAM_STR);
            $query->bindParam(':editedAt', $editedAt, PDO::PARAM_INT);
            $query->execute();

            $rowCount = $query->rowCount();

            if ($rowCount == 0)
            {
                if ($writeDb->inTransaction())
                {
                    $writeDb->rollBack();
                }
                return false;
            }

            if (!$updatedMacroprocessoArray = $this->getMacroprocessoInDatabase($macroprocessoId))
            {
                if ($writeDb->inTransaction())
                {
                    $writeDb->rollBack();
                }
                return false;
            }

            $writeDb->commit();

            return $updatedMacroprocessoArray;
        }
        catch (PDOException $ex)
        {
            if ($writeDb->inTransaction())
            {
                $writeDb->rollBack();
            }
            $response = new Response();
            $response->setSuccess(false);
            $response->setHttpStatusCode(500);
            $response->addMessage('Algo deu errado - tente novamente');
            $response->send();
            exit;
        }
    }

    protected static function getAllMacroprocessosInDatabase()
    {
        try
        {
            $writeDb = DB::connectWriteDb();

            $query = $writeDb->prepare('select * from macroprocesso');
            $query->execute();

            $macroprocessoArrays = array();

            while ($row = $query->fetch(PDO::FETCH_ASSOC))
            {
                $macroprocessoArrays[] = $row;
            }
            
            return $macroprocessoArrays;
        }
        catch (PDOException $ex)
        {
            if ($writeDb->inTransaction())
            {
                $writeDb->rollBack();
            }
            $response = new Response();
            $response->setSuccess(false);
            $response->setHttpStatusCode(500);
            $response->addMessage('Algo deu errado - tente novamente');
            $response->send();
            exit;
        }
    }
}