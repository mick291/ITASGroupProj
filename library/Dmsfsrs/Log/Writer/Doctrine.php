<?php
class Dmsfsrs_Log_Writer_Doctrine
    extends Zend_Log_Writer_Abstract
{
    /**
     * @var string
     */
    protected $_modelClass = null;

    /**
     * @var array
     */
    protected $_columnMap = array();

    /**
     * Constructor
     *
     * @param   string $modelClass
     * @param   array $columnMap
     * @return  void
     * @throws  Zend_Log_Exception
     */
    public function __construct($modelClass, $columnMap = null)
    {
        if (!is_string($modelClass)) {
            throw new Zend_Log_Exception('Invalid model class.');
        }

        if (!class_exists($modelClass)) {
            throw new Zend_Log_Exception('Invalid model class.');
        }

        $this->_modelClass = $modelClass;

        $this->_columnMap = $columnMap;
    }

    /**
     * Create a new instance of Zend_Log_Writer_Doctrine
     *
     * @param  array|Zend_Config $config
     * @return Zend_Log_Writer_Db
     * @throws Zend_Log_Exception
     */
    static public function factory($modelClass, $columnMap = null)
    {
        return new self(
            $modelClass,
            $columnMap = null
        );
    }
    /**
     * Disable formatting
     *
     * @param   mixed $formatter
     * @return  void
     * @throws  Zend_Log_Exception
     */
    public function setFormatter($formatter)
    {
        throw new Zend_Log_Exception('Formatting is not supported.');
    }

    /**
     * Write a message to the log
     *
     * @param   array $event
     * @return  void
     */
    protected function _write($event)
    {
        $dataToInsert = array();

        if (null === $this->_columnMap) {
            $dataToInsert = $event;
        } else {
            foreach ($this->_columnMap as $columnName => $fieldKey) {
                $dataToInsert[$columnName] = $event[$fieldKey];
            }
        }

        $entry = new $this->_modelClass();
        $entry->fromArray($dataToInsert);
        $entry->save();
    }
}