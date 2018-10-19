<?php

/**
 * admin/classes/form.php
 */
class Form
{
    
    public $xml;
    public $data;
    public $raw_data;
    public $database;
    
    public function __construct($xml, $data, $database)
    {
        if (file_exists($xml))
        {
            $this->xml = simplexml_load_file($xml);
            $this->data = (object) $data;
            $this->raw_data = $data;
            $this->database = $database;
        }
        else
        {
            $this->xml = new stdClass();
            $this->data = (object) $data;
            $this->raw_data = $data;
            $this->database = $database;
        }
    }
    
    /**
     * Output the inner section of a HTML form
     * 
     * @param bool $display_submit
     *   show/hide the submit button
     * @param bool $is_extra_config
     *   are the fields nested?
     */
    public function display($display_submit = true, $is_extra_config = false)
    {
        $string = '';
        foreach ($this->xml->fields as $field) {
            $attributes = $field->attributes();
            $name = $attributes->name;
            $type = $attributes->type;
            $default = $attributes->default;
            $label = $attributes->label;
            
            $field_name = $name;
            if (substr($name, 0, 7) == "params[")
            {
                if (!is_array($this->data->params)) $this->data->params = (array) $this->data->params;
                $temp_name = rtrim(explode("params[", $name)[1], "]");
                $field_value = $this->data->params[$temp_name];
            }
            else
            {
                $field_value = $this->data->$name;
            }
            
            if (is_array($field_value))
            {
                $value = count($field_value) > 0 ? $field_value : $default;
            }
            else
            {
                $value = strlen($field_value) > 0 ? $field_value : $default;
            }

            $string .= '<div class="form-group"';
            $string .= $type == "hidden" ? ' style="display: none;"' : '';
            $string .= '>';
            $string .= '<label>'.$label.'</label>';

            switch ($type) {
                case "select":
                case "sql":
                    $string .= $this->generateSelectSqlField($field_name, $value, $attributes);
                    break;
                case "textarea":
                    $string .= $this->generateTextareaField($field_name, $value, $attributes);
                    break;
                case "date":
                    $string .= $this->generateDateField($field_name, $value, $attributes);
                    break;
                case "template_position":
                    $string .= $this->generateTemplatePositionField($attributes);
                    break;
                case "template_picker":
                    $string .= $this->generateTemplatePickerField($field_name, $value, $attributes);
                    break;
                case "file":
                    $string .= $this->generateFileUploadField($field_name, $value, $attributes, $is_extra_config);
                    break;
                default:
                    $string .= $this->generateTextField($field_name, $value, $attributes);
                    break;
            }

            $string .= '</div>';
        }

        if ($display_submit)
        {
            $string .= '<button type="submit" class="btn btn-success float-right no-margin"><i class="fa fa-save"></i> Save</button>';
        }
        $string .= '<div class="clearfix"></div>';

        echo $string;
    }
    
    public function displaySelect($items, $field_name, $current = "", $multiple = false, $class = "", $label = "", $default = "")
    {
        $string = '<div class="form-group"><label>'. (strlen($label) > 0 ? $label : $field_name) .'</label>';
        $string .= '<select name="'.$field_name;
        if ($multiple == "true")
        {
            $string .= '[]" multiple class="form-control';
        }
        else
        {
            $string .= '" class="form-control';
        }
        if (strlen($class) > 0)
        {
            $string .= ' '. $class;
        }
        $string .= '">';
        foreach ($items as $option)
        {
            $string .= '<option value="'.$option->value.'" ';
            if ($current == $option->value || $default == $option->value && strlen($current) <= 0)
            {
                $string .= 'selected="selected"';
            }
            $string .= '>'.$option->name.'</option>';
        }
        $string .= '</select></div>';
        echo $string;
    }

    /**
     * Generates an HTML text field
     * 
     * @param string $field_name
     * @param string $value
     * @param object $attributes
     */
    protected function generateTextField($field_name, $value, $attributes)
    {
        $string = '<input type="'.$attributes->type.'" name="'.$field_name.'" class="form-control';
        if (strlen($attributes->class) > 0)
        {
            $string .= ' '. $attributes->class;
        }
        $string .= '" value="'.$value.'"';

        if (strlen($attributes->placeholder) > 0)
        {
            $string .= ' placeholder="'. $attributes->placeholder .'"';
        }
        if ($attributes->length > 0) {
            $string .= 'maxlength="'.$attributes->length.'"';
        }
        if ($attributes->required == "required")
        {
            $string .= ' required';
        }
        $string .= '/>';

        return $string;
    }

    /**
     * Generates a file upload field
     * @param string $field_name
     * @param string $value
     * @param object $attributes
     * @param bool $is_extra_config
     */
    protected function generateFileUploadField($field_name, $value, $attributes, $is_extra_config)
    {
        $string = '';
        $folder_name = $is_extra_config ? "params[". $name ."_folder]" : $name ."_folder";

        if (strlen($value) > 0)
        {
            $string = '<img src="../'. $value .'" style="max-width: 50%; margin-bottom: 20px; display: block;">';
        }

        $string .= '<input type="file" class="form-control';
        $string .= $this->addClassAttr($attributes->class);
        $string .= '" name="'. $field_name .'" />';

        if ($attributes->required == "required")
        {
            $string .= ' required';
        }

        $string .= '<input type="hidden" name="'. $folder_name .'" value="'. $attributes->folder .'" />';
        return $string;
    }

    /**
     * Generates a Template picker field
     * 
     * @param string $field_name
     * @param string $value
     * @param object $attributes
     */
    protected function generateTemplatePickerField($field_name, $value, $attributes)
    {
        if ($field_name == "params[admin_template]")
        {
            $dirs = scandir(__DIR__ ."/../templates");
        }
        else
        {
            $dirs = scandir(__DIR__ ."/../../templates");
        }
        unset($dirs["0"], $dirs["1"]); // remove higher directory levels

        $string = '<select name="'. $field_name .'" class="form-control';
        $string .= $this->addClassAttr($attributes->class);
        $string .= '">';

        foreach ($dirs as $dir)
        {
            $string .= '<option value="'.$dir .'"';
            if ($value == $dir)
            {
                $string .= ' selected="selected"';
            }
            $string .= '>';

            if ($field_name == "params[admin_template]")
            {
                $xml = simplexml_load_file(BASE_DIR ."/templates/". $dir ."/template.xml");
            }
            else
            {
                $xml = simplexml_load_file(BASE_DIR ."/../templates/". $dir ."/template.xml");
            }
            $string .= $xml->name;
            $string .= '</option>';
        }
        $string .= '</select>';
        return $string;
    }

    /**
     * Template Position field
     * 
     * @todo Is this field name always static?
     * @param object $attributes
     */
    protected function generateTemplatePositionField($attributes)
    {
        $config = Core::config();
        $xml = simplexml_load_file(BASE_DIR ."/../templates/". $config->default_template ."/template.xml");

        $string = '<select name="position" class="form-control';
        $string .= $this->addClassAttr($attributes->class);
        $string .= '">';

        foreach ($xml->position as $position)
        {
            $string .= '<option value="'. $position .'"';
            if ($this->data->position == $position)
            {
                $string .= ' selected="selected"';
            }
            $string .= '>'. $position .'</option>';
        }
        $string .= '</select>';
        return $string;
    }

    /**
     * Generates HTML for a date field
     * 
     * @param string $field_name
     * @param string $value
     * @param object $attributes
     */
    protected function generateDateField($field_name, $value, $attributes)
    {
        $string = '<input type="date" name="'.$field_name.'" class="form-control';
        $string .= $this->addClassAttr($attributes->class);

        if ($value == 0 && $value != $attributes->default)
        {
            $value = date("Y-m-d", time());
        }
        elseif ($value > 0)
        {
            $value = date("Y-m-d", $value);
        }
        $string .= '" value="' . $value . '"';

        if ($attributes->required == "required")
        {
            $string .= ' required';
        }
        $string .= '/>';

        return $string;
    }

    /**
     * Generates HTML for a textarea field
     * 
     * @param string $field_name
     * @param string $value
     * @param object $attributes
     */
    protected function generateTextareaField($field_name, $value, $attributes)
    {
        $string = '<textarea name="'.$field_name.'" class="form-control';
        $string .= $this->addClassAttr($attributes->class);
        $string .= '"';
        if ($attributes->required == "required")
        {
            $string .= ' required';
        }
        $string .= '>'.$value.'</textarea>';

        return $string;
    }

    /**
     * Generates HTML for a select list field
     * 
     * @param string $field_name
     * @param object $attributes
     */
    protected function generateSelectSqlField($field_name, $value, $attributes)
    {
        $multiple = $attributes->multiple; // applies to select / sql
        $query = $attributes->query; // applies to sql
        $default_option = $attributes->default_option; // applies to sql
        $values = $attributes->values; // applies to select (, seperated) label|value
        $selectdefault = $attributes->selectdefault; // applies to sql (label|value)

        $string = '<select name="'.$field_name;
        if ($multiple == "true")
        {
            $string .= '[]" multiple class="form-control';
        }
        else
        {
            $string .= '" class="form-control';
        }
        $string .= $this->addClassAttr($attributes->class);
        $string .= '"';
        if ($attributes->required == "required")
        {
            $string .= ' required';
        }
        $string .= '>';

        if ($attributes->type == "sql")
        {
            $db = Core::db();
            $options = $db->loadObjectList($query);

            // array[object{id,title}]
            $key = $attributes->key;
            $keyvalue = $attributes->keyvalue;
            
            $finalOptions = [];

            if (strlen($default_option) > 0)
            {
                $finalOptions[] = $default_option;
            }

            foreach ($options as $option) {
                $option = (object) $option;
                $finalOptions[] = $option->$keyvalue . '|' . $option->$key;
            }
        }
        else
        {
            $finalOptions = explode(",", $values);
        }

        foreach ($finalOptions as $option)
        {
            $option = explode("|", $option);
            $string .= '<option value="'.$option[1].'" ';
            if (is_array($value))
            {
                if (in_array($option[1], $value) || ($option[1] == $attributes->default && count($value) <= 0))
                {
                    $string .= 'selected="selected"';
                }
            }
            else
            {
                if ($value == $option[1] || ($option[1] == $attributes->default && strlen($value) <= 0))
                {
                    $string .= 'selected="selected"';
                }
            }
            $string .= '>'.$option[0].'</option>';
        }

        $string .= '</select>';

        return $string;
    }

    /**
     * Simply outputs the class attribute
     * 
     * @param string $classes
     */
    protected function addClassAttr($classes)
    {
        return strlen($classes) > 0 ? ' ' . $classes : '';
    }
    
    public function displaySql($controller, $name, $current, $db, $label = "")
    {
        $string = '<div class="form-group"><label>'. (strlen($label) > 0 ? $label : $controller->attributes()->label) .'</label>';
        $string .= '<select name="'.$name.'" class="form-control">';
        $options = $db->loadObjectList($controller->attributes()->query);
        foreach ($options as $option) {
            $key = $controller->attributes()->key;
            $keyvalue = $controller->attributes()->keyvalue;
            $string .= '<option value="'.$option->$key.'" ';
            if ($current == $option->$key)
            {
                $string .= 'selected="selected"';
            }
            $string .= '>'.$option->$keyvalue.'</option>';
        }
        $string .= '</select></div>';
        echo $string;
    }
    
}
