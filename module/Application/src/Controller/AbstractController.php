<?php

namespace Application\Controller;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\Driver\Pgsql;
use Zend\Db\Sql\Sql;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\MvcEvent;
use Zend\View\Helper\HeadLink;
use Zend\View\Helper\HeadMeta;
use Zend\View\Helper\HeadScript;
use Zend\View\Helper\HeadTitle;
use Zend\View\Helper\InlineScript;
use Zend\View\HelperPluginManager;

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

    protected function getDbSql()
    {
        return new Sql($this->dbAdapter);
    }

    protected final function addError($message)
    {
        $this->errors[] = $message;
    }

    protected final function getErrorsCount()
    {
        return count($this->errors);
    }

    /**
     * @return HelperPluginManager
     */
    protected function getViewHelperManager()
    {
        return $this->getEvent()->getApplication()->getServiceManager()->get('ViewHelperManager');
    }

    /**
     * @return HeadTitle
     */
    protected function getHeadTitle()
    {
        return $this->getViewHelperManager()->get('headTitle');
    }

    /**
     * @return HeadMeta
     */
    protected function getHeadMeta()
    {
        return $this->getViewHelperManager()->get('headMeta');
    }

    /**
     * @return HeadScript
     */
    protected function getHeadScript()
    {
        return $this->getViewHelperManager()->get('headScript');
    }

    /**
     * @return InlineScript
     */
    protected function getInlineScript()
    {
        return $this->getViewHelperManager()->get('inlineScript');
    }

    /**
     * @return HeadLink
     */
    protected function getHeadLink()
    {
        return $this->getViewHelperManager()->get('headLink');
    }

    protected function appendAdditionalScripts(array $jsList)
    {
        $headScript = $this->getHeadScript();
        foreach ($jsList as $jsPath) {
            $headScript->appendFile($jsPath);
        }
    }

    protected function appendAdditionalStylesheets(array $cssList)
    {
        $headLink = $this->getHeadLink();
        foreach ($cssList as $cssPath) {
            $headLink->appendStylesheet($cssPath, null);
        }
    }

    public function onDispatch(MvcEvent $e)
    {
        $this->appendAdditionalScripts([
            '/js/vendor/jquery.min.js',
            '/js/main.js',
        ]);

        return parent::onDispatch($e);
    }
}