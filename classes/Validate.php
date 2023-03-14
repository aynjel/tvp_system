<?php

class Validate{
    private $_passed = false,
            $_errors = [],
            $_db = null;

    public function __construct(){
        $this->_db = Database::getInstance();
    }

    public function check($source, $items = []){
        foreach($items as $item => $rules){
            foreach($rules as $rule => $rule_value){
                $value = trim($source[$item]);
                $item = H::sanitize($item);

                if($rule === 'required' && empty($value)){
                    $this->addError("{$rules['display']} is required");
                }else if(!empty($value)){
                    switch($rule){
                        case 'min':
                            if(strlen($value) < $rule_value){
                                $this->addError("{$rules['display']} must be a minimum of {$rule_value} characters");
                            }
                        break;
                        case 'max':
                            if(strlen($value) > $rule_value){
                                $this->addError("{$rules['display']} must be a maximum of {$rule_value} characters");
                            }
                        break;
                        case 'matches':
                            if($value != $source[$rule_value]){
                                $matchItem = H::sanitize($rule_value);
                                $matchDisplay = $items[$matchItem]['display'];
                                $this->addError("{$matchDisplay} and {$rules['display']} must match");
                            }
                        break;
                        case 'email':
                            if(!filter_var($value, FILTER_VALIDATE_EMAIL)){
                                $this->addError("{$rules['display']} is not a valid email address");
                            }
                        break;
                        case 'unique':
                            $check = $this->_db->query("SELECT * FROM {$rule_value} WHERE {$item} = ?", [$value]);
                            if($check->count()){
                                $this->addError("{$rules['display']} already exists. Please choose another {$rules['display']}");
                            }
                        break;
                        case 'unique_update':
                            $t = explode(',', $rule_value);
                            $table = $t[0];
                            $id = $t[1];
                            $query = $this->_db->query("SELECT * FROM {$table} WHERE id != ? AND {$item} = ?", [$id, $value]);
                            if($query->count()){
                                $this->addError("{$rules['display']} already exists. Please choose another {$rules['display']}");
                            }
                        break;
                        case 'is_numeric':
                            if(!is_numeric($value)){
                                $this->addError("{$rules['display']} must be a number");
                            }
                        break;
                        case 'valid_phone_number':
                            if(!preg_match('/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/', $value)){
                                $this->addError("{$rules['display']} must be a valid phone number");
                            }
                        break;
                        case 'valid_date':
                            $date = DateTime::createFromFormat('m/d/Y', $value);
                            if(!$date){
                                $this->addError("{$rules['display']} must be a valid date");
                            }
                        break;
                        case 'valid_time':
                            $time = DateTime::createFromFormat('H:i', $value);
                            if(!$time){
                                $this->addError("{$rules['display']} must be a valid time");
                            }
                        break;
                        case 'valid_name':
                            if(!preg_match('/^[a-zA-Z ]*$/', $value)){
                                $this->addError("{$rules['display']} must be a valid name");
                            }
                        break;
                        case 'valid_username':
                            if(!preg_match('/^[a-zA-Z0-9_]*$/', $value)){
                                $this->addError("{$rules['display']} must be a valid username");
                            }
                        break;
                        case 'valid_password':
                            if(!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,12}$/', $value)){
                                $this->addError("{$rules['display']} must be a valid password");
                            }
                        break;
                        case 'valid_zipcode':
                            if(!preg_match('/^[0-9]{5}(?:-[0-9]{4})?$/', $value)){
                                $this->addError("{$rules['display']} must be a valid zipcode");
                            }
                        break;
                        case 'valid_address':
                            if(!preg_match('/^[a-zA-Z0-9\s,]*$/', $value)){
                                $this->addError("{$rules['display']} must be a valid address");
                            }
                        break;
                    }
                }
            }
        }

        if(empty($this->_errors)){
            $this->_passed = true;
        }

        return $this;
    }

    private function addError($error){
        $this->_errors[] = $error;
    }

    public function errors(){
        return $this->_errors;
    }

    public function passed(){
        return $this->_passed;
    }
}