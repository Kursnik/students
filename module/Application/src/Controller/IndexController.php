<?php

namespace Application\Controller;

use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\View\Model\JsonModel;

class IndexController extends AbstractController
{
    private function getListByQueryResult(ResultInterface $result, $keyField = null, $valueField = null)
    {
        $list = [];
        foreach ($result as $row) {
            $value = $valueField ? $row[$valueField] : $row;
            if ($keyField) {
                $list[$row[$keyField]] = $value;
            } else {
                $list[] = $value;
            }
        }

        return $list;
    }

    private function findEducationsList()
    {
        return $this->getListByQueryResult(
            $this->executeQuery('select id as id, title as title from education order by title'),
            'id',
            'title'
        );
    }

    private function findCityList()
    {
        return $this->getListByQueryResult(
            $this->executeQuery('select id as id, title as title from city order by title'),
            'id',
            'title'
        );
    }

    private function getData(array $educationsList, array $cityList)
    {
        /*
           select u.name,
                  e.title as education,
                  c.title as city
             from users u
                    inner join user_education ue on ue.user_id = u.id
                    inner join education e on e.id = ue.education_id
                    inner join user_city uc on uc.user_id = u.id
                    inner join city c on c.id = uc.city_id
            where e.id in (...)
              and c.id in (...)
         */
        $sql = $this->getDbSql();
        $select = $sql->select()
            ->from(['u' => 'users'])
            ->columns(['name'])
            ->join(['ue' => 'user_education'], 'ue.user_id = u.id', [])
            ->join(['e' => 'education'], 'e.id = ue.education_id', ['education' => 'title'])
            ->join(['uc' => 'user_city'], 'uc.user_id = u.id', [])
            ->join(['c' => 'city'], 'c.id = uc.city_id', ['city' => 'title']);
        $select->where
            ->in('e.id', array_keys($educationsList))
            ->in('c.id', array_keys($cityList));

        $selectString = $sql->buildSqlString($select);

        return $this->getListByQueryResult(
            $this->executeQuery($selectString)
        );
    }

    public function indexAction()
    {
        $url = $this->url()->fromRoute('home/info');
        $this->getInlineScript()->appendScript(
            '$(function() {
                 Students.init(\'' . $url . '\');
             });'
        );

        $educationsList = $this->findEducationsList();
        $cityList = $this->findCityList();
        return [
            'refreshable'    => false,
            'educationsList' => $educationsList,
            'cityList'       => $cityList,
            'data'           => $this->getData($educationsList, $cityList)
        ];
    }

    public function infoAction()
    {
        $educationsList = $this->params()->fromPost('education', []);
        $cityList = $this->params()->fromPost('city', []);

        return new JsonModel(
            (is_array($educationsList) && count($educationsList)
                && is_array($cityList) && count($cityList))
                ? $this->getData($educationsList, $cityList)
                : []
        );
    }
}
