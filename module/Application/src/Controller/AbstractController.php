<?php

namespace Application\Controller;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\Driver\Pgsql;
use Zend\Mvc\Controller\AbstractActionController;

abstract class AbstractController extends AbstractActionController
{
    private $dbAdapter;
    private $errors = [];

    public function __construct(Adapter $dbAdapter = null)
    {
        $this->dbAdapter = $dbAdapter;
    }

    private final function getConnection()
    {
        return $this->dbAdapter->getDriver()->getConnection();
    }

    protected final function beginTransaction()
    {
        $this->getConnection()->beginTransaction();
    }
    protected final function commit()
    {
        $this->getConnection()->commit();
    }
    protected final function rollback()
    {
        $this->getConnection()->rollback();
    }

    protected final function executeQuery($sql, array $binds = [])
    {
        return $this->dbAdapter->query($sql)->execute($binds);
    }

    protected final function addError($message)
    {
        $this->errors[] = $message;
    }

    protected final function getErrorsCount()
    {
        return count($this->errors);
    }
}