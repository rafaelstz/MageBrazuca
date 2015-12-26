<?php

namespace AppBundle\Service;

/**
 * @author Matheus Gontijo <matheus@matheusgontijo.com>
 */
class ServiceException extends \Exception
{
    /**
     * @var array
     */
    private $_errors;

    public function __construct(array $errors)
    {
        parent::__construct('The service has errors.');
        $this->setErrors($errors);
    }

    /**
     * @param array $errors
     */
    public function setErrors(array $errors)
    {
        $this->_errors = $errors;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->_errors;
    }
}
