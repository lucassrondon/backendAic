<?php

require_once('../model/MacroprocessoModel.class.php');

class MacroprocessoException extends Exception {}

class MacroprocessoController extends MacroprocessoModel
{
    private $id;
    private $name;
    private $createdAt;
    private $editedAt;

    public function __construct($id, $name, $createdAt, $editedAt)
    {
        $this->setId($id);
        $this->setName($name);
        $this->setCreatedAt($createdAt);
        $this->setEditedAt($editedAt);
    }

    public function setId($id)
    {
        if ($id !== null && !is_numeric($id))
        {
            throw new MacroprocessoException('Id inválido');
        }
        $this->id = $id;
    }

    public function setName($name)
    {
        if ($name !== null && empty($name))
        {
            throw new MacroprocessoException('Nome inválido');
        }
        $this->name = $name;
    }

    public function setCreatedAt($createdAt)
    {
        if ($createdAt !== null && !is_numeric($createdAt))
        {
            throw new MacroprocessoException('Data de criação inválida');
        }
        $this->createdAt = $createdAt;
    }

    public function setEditedAt($editedAt)
    {
        if ($editedAt !== null && !is_numeric($editedAt))
        {
            throw new MacroprocessoException('Data de edição inválida');
        }
        $this->editedAt = $editedAt;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function getEditedAt()
    {
        return $this->editedAt;
    }

    public function createMacroprocesso()
    {
        $name = $this->getName();
        $createdAt = $this->getCreatedAt();

        return $this->createMacroprocessoInDatabase($name, $createdAt);
    }

    public function getMacroprocesso()
    {
        $macroprocessoId = $this->getId();

        return $this->getMacroprocessoInDatabase($macroprocessoId);
    }

    public function deleteMacroprocesso()
    {
        $macroprocessoId = $this->getId();

        return $this->deleteMacroprocessoInDatabase($macroprocessoId);
    }

    public function updateMacroprocesso()
    {
        $macroprocessoId = $this->getId();
        $name = $this->getName();
        $editedAt = $this->getEditedAt();

        return $this->updateMacroprocessoInDatabase($macroprocessoId, $name, $editedAt);
    }

    public static function getAllMacroprocessos()
    {
        return self::getAllMacroprocessosInDatabase();
    }
}

