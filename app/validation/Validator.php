<?php
namespace App\Validation;

use Respect\Validation\Validator as Respect;
use Respect\Validation\Exceptions\NestedValidationException;

// Creamos una clase nueva para validar los datos de formularios y crear nuestras propias reglas (custom validators).
class Validator
{
    private $errors;
    
    public function validate($request, array $rules)
    {
        foreach ($rules as $field => $rule) {
            try {
                $rule->setName(ucfirst($field))->assert($request->getParsedBodyParam($field));
            } catch(NestedValidationException $e) {
                $this->errors[$field] = $e->getMessages();
            }
        }
        
//        var_dump($this);
//        die;
        return $this;
    }
    
    public function getErrors(){
        return $this->errors;
    }
    
    public function failed(){
        return !empty($this->errors);
    }
}
