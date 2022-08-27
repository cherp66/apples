<?php 

namespace application\core\adapters;

use application\core\interfaces\EntityInterface;
use application\core\Hydrator;
use yii\db\Command;
use yii\helpers\BaseInflector as Inflector;

/**
 * Class Repository
 * @package application\core
 */
class Repository extends Command
{
    protected $table;

    /**
     * @param string|null $id
     * @param string $class
     * @return EntityInterface
     * @throws \yii\db\Exception
     */
    public function getEntity(?string $id, string $class) : EntityInterface
    {
        $data = $this->createCommand("SELECT *
                                            FROM {{". $this->getTable() ."}}
                                             WHERE [[id]] = '". $id ."'"
                        )->queryOne();
        if (empty($data)) {
            throw new \DomainException('The '. basename($class) .' aggregate with ID = '
                                                . ($id ?: 'null') .' was not found');
        }

        $data = $this->extractResult($data);
        return Hydrator::fill($class, $data);
    }

    /**
     * @param string|null $field
     * @return array
     * @throws \ReflectionException
     * @throws \yii\db\Exception
     */
    public function getColumn(?string $field = null, ?string $where = null, int $limit = 100) : array
    {
         $res = $this->createCommand("SELECT {{". $field ."}}
                                          FROM {{". $this->getTable() ."}}
                                          ". $where ."
                                          LIMIT ". $limit
                )->queryAll();
         $out = [];
         foreach($res as $row) {
             $out[] = $row[$field];
         }
         return $out;
    }

    /**
     * @param string $entity
     * @param array $data
     * @return bool
     * @throws \yii\db\Exception
     */
    public function saveEntity(string $entity, array $data): bool
    {
        $name = Inflector::underscore($entity);
        $bindData   = $this->prepareBindData($data);
        $insertData = $this->prepareWriteData($data);
        array_shift($data);
        $updateData = $this->prepareWriteData($data);
        $this->createCommand("INSERT INTO {{". $name ."}}
                                      SET  ". implode(",\n", $insertData) ."
                                      ON DUPLICATE KEY UPDATE "
                                    . implode(",\n", $updateData))
               ->bindValues($bindData)
               ->execute();


        return true;
    }

    /**
     * @param array $data
     * @return array
     */
    protected function extractResult(array $data) : array
    {
        $prepareData = [];    
        foreach($data as $name => $value) {
            $prepareData[Inflector::variablize($name)] = $value;
        }
        return $prepareData;
    }

    /**
     * @param array $data
     * @return array
     */
    private function prepareWriteData(array $data) : array
    { 
        $prepareData = [];    
        foreach($data as $name => $v) {
            $prepareData[] = '[['. $name .']]=:'. $name;
        }
        
        return $prepareData;
    }

    /**
     * @param array $data
     * @return array
     */
    private function prepareBindData(array $data): array
    { 
        $prepareData = [];    
        foreach($data as $name => $value) {
            $prepareData[':'. $name] = $value;
        }
        
        return $prepareData;
    }

    /**
     * @return string
     */
    private function getTable() : string
    {
        return $this->table;
    }

    private function createCommand($query = null)
    {
        $this->db = \Yii::$app->db;

        if (null !== $query) {
            $this->setSql($query);
        }

        return $this;
    }
}
