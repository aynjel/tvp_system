<?php

class FH{
    public static function stringifyAttrs($attrs){
        $string = '';
        foreach($attrs as $key => $value){
            $string .= $key . '="' . $value . '" ';
        }
        return $string;
    }

    public static function InputBlock($type, $label, $name, $value = '', $attrs = [], $inputAttrs = [], $helpText = ''){
        $divString = self::stringifyAttrs($attrs);
        $inputString = self::stringifyAttrs($inputAttrs);
        $html = '<div ' . $divString . '>';
        $html .= '<label for="' . $name . '">' . $label . '</label>';
        $html .= '<input type="' . $type . '" id="' . $name . '" name="' . $name . '" value="' . $value . '" ' . $inputString . '>';
        $html .= '<span class="help-block">' . $helpText . '</span>';
        $html .= '</div>';
        return $html;
    }

    public static function SelectBlock($label, $name, $options = [], $selectedValue = '', $attrs = [], $inputAttrs = [], $helpText = ''){
        $divString = self::stringifyAttrs($attrs);
        $inputString = self::stringifyAttrs($inputAttrs);
        $html = '<div ' . $divString . '>';
        $html .= '<label for="' . $name . '">' . $label . '</label>';
        $html .= '<select id="' . $name . '" name="' . $name . '" ' . $inputString . '>';
        foreach($options as $value => $display){
            $selected = ($value == $selectedValue) ? 'selected' : '';
            $html .= '<option value="' . $value . '" ' . $selected . '>' . $display . '</option>';
        }
        $html .= '</select>';
        $html .= '<span class="help-block">' . $helpText . '</span>';
        $html .= '</div>';
        return $html;
    }

    public static function TextareaBlock($label, $name, $value = '', $attrs = [], $inputAttrs = [], $helpText = ''){
        $divString = self::stringifyAttrs($attrs);
        $inputString = self::stringifyAttrs($inputAttrs);
        $html = '<div ' . $divString . '>';
        $html .= '<label for="' . $name . '">' . $label . '</label>';
        $html .= '<textarea id="' . $name . '" name="' . $name . '" ' . $inputString . '>' . $value . '</textarea>';
        $html .= '<span class="help-block">' . $helpText . '</span>';
        $html .= '</div>';
        return $html;
    }

    public static function csrfInput(){
        $token = FH::generateToken();
        $_SESSION['csrf_token'] = $token;
        return '<input type="hidden" name="csrf_token" value="' . $token . '">';
    }

    public static function generateToken(){
        return bin2hex(random_bytes(32));
    }

    public static function verifyToken($token){
        if(isset($_SESSION['csrf_token']) && $token === $_SESSION['csrf_token']){
            unset($_SESSION['csrf_token']);
            return true;
        }
        return false;
    }

    public static function displayErrors($errors = []){
        $html = '<div class="alert alert-danger" role="alert"><ul>';
        foreach($errors as $error){
            $html .= '<li>' . $error . '</li>';
        }
        $html .= '</ul></div>';
        return $html;
    }
}