<?php

namespace GonteroAcl\Exception;


class UnathorizedException extends \LogicException
{
    protected $message = 'Błąd autoryzacji';
    protected $code = \Zend\Http\Response::STATUS_CODE_401;

}