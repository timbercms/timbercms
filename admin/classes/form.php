<?php

	class Form
	{
        
        public $xml;
        public $data;
        public $raw_data;
        public $database;
        
		public function __construct($xml, $data, $database)
		{
            $this->xml = simplexml_load_file($xml);
            $this->data = (object) $data;
            $this->raw_data = $data;
            $this->database = $database;
        }
        
        public function display($display_submit = true, $is_extra_config = false)
        {
            $string = '';
            foreach ($this->xml->fields as $field) {
                $name = $field->attributes()->name;
                if ($is_extra_config)
                {
                    $field_name = "params[". $field->attributes()->name ."]";
                }
                else
                {
                    $field_name = $field->attributes()->name;
                }
                $type = $field->attributes()->type;
                $length = $field->attributes()->length;
                if (is_array($this->data->$name))
                {
                    if (count($this->data->$name) > 0)
                    {
                        $value = $this->data->$name;
                    }
                    else
                    {
                        $value = $field->attributes()->default;
                    }
                }
                else
                {
                    if (strlen($this->data->$name) > 0)
                    {
                        $value = $this->data->$name;
                    }
                    else
                    {
                        $value = $field->attributes()->default;
                    }
                }
                $string .= '<div class="row form-group"';
                if ($type == "hidden") {
                    $string .= 'style="display: none;"';
                }
                $string .= '>';
                $string .= '<label class="col-md-2 col-form-label">'.$field->attributes()->label.'</label>';
                $string .= '<div class="col-md-10">';
                if ($type != "textarea" && $type != "select" && $type != "sql" && $type != "template_position" && $type != "file" && $type != "date") {
                    $string .= '<input type="'.$type.'" name="'.$field_name.'" class="form-control';
                    if (strlen($field->attributes()->class) > 0)
                    {
                        $string .= ' '. $field->attributes()->class;
                    }
                    $string .= '" value="'.$value.'"';
                    if ($length > 0) {
                        $string .= 'maxlength="'.$length.'"';
                    }
                    $string .= '/>';
                } elseif ($type == "select" || $type == "sql") {
                    $string .= '<select name="'.$field_name;
                    if ($field->attributes()->multiple == "true")
                    {
                        $string .= '[]" multiple class="form-control';
                    }
                    else
                    {
                        $string .= '" class="form-control';
                    }
                    if (strlen($field->attributes()->class) > 0)
                    {
                        $string .= ' '. $field->attributes()->class;
                    }
                    $string .= '">';
                    if ($field->attributes()->type == "sql") {
                        $db = new Database();
                        $options = $db->loadObjectList($field->attributes()->query);
                        if (strlen($field->attributes()->default_option) > 0)
                        {
                            $default = explode("|", $field->attributes()->default_option);
                            $default_field = $field_name;
                            $string .= '<option value="'. $default["0"] .'"';
                                if (is_array($this->data->$default_field) && in_array($default["0"], $this->data->$default_field) || !is_array($this->data->$default_field) && strlen($this->data->$default_field) <= 0 && $field->attributes()->selectdefault != 0)
                                {
                                    $string .= ' selected="selected"';
                                }
                            $string .= '>'. $default["1"] .'</option>';
                        }
                        foreach ($options as $option) {
                            $option = (object) $option;
                            $key = $field->attributes()->key;
                            $keyvalue = $field->attributes()->keyvalue;
                            $string .= '<option value="'.$option->$key.'" ';
                            if (is_array($this->data->$name))
                            {
                                if (in_array($option->$key, $this->data->$name) || $option->$key == $field->attributes()->default && count($this->data->$name) <= 0) {
                                    $string .= 'selected="selected"';
                                }
                            }
                            else
                            {
                                if ($this->data->$name == $option->$key || $option->$key == $field->attributes()->default && strlen($this->data->$name) <= 0)
                                {
                                    $string .= 'selected="selected"';
                                }
                            }
                            $string .= '>'.$option->$keyvalue.'</option>';
                        }
                    } else {
                        $options = explode(",", $field->attributes()->values);
                        foreach ($options as $option) {
                            $option = explode("|", $option);
                            $string .= '<option value="'.$option["1"].'" ';
                            if (is_array($this->data->$name))
                            {
                                if (in_array($option["1"], $this->data->$name) || $option["1"] == $field->attributes()->default && count($this->data->$name) <= 0) {
                                    $string .= 'selected="selected"';
                                }
                            }
                            else
                            {
                                if ($this->data->$name == $option["1"] || $option["1"] == $field->attributes()->default && strlen($this->data->$name) <= 0)
                                {
                                    $string .= 'selected="selected"';
                                }
                            }
                            $string .= '>'.$option["0"].'</option>';
                        }
                    }
                    $string .= '</select>';
                } elseif ($type == "template_position") {
                    $config = Core::config();
                    $xml = simplexml_load_file(BASE_DIR ."/../templates/". $config->default_template ."/template.xml");
                    $string .= '<select name="position" class="form-control';
                    if (strlen($field->attributes()->class) > 0)
                    {
                        $string .= ' '. $field->attributes()->class;
                    }
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
                } elseif ($type == "file") {
                    if ($is_extra_config)
                    {
                        $folder_name = "params[". $name ."_folder]";
                    }
                    else
                    {
                        $folder_name = $name;
                    }
                    if (strlen($field->attributes()->image) > 0)
                    {
                        $string .= '<img src="../'. $value .'" style="max-width: 50%; margin-bottom: 20px;" />';
                    }
                    $string .= '<input type="file" class="form-control';
                    if (strlen($field->attributes()->class) > 0)
                    {
                        $string .= ' '. $field->attributes()->class;
                    }
                    $string .= '" name="'. $field_name .'" />';
                    $string .= '<input type="hidden" name="'. $folder_name .'" value="'. $field->attributes()->folder .'" />';
                } elseif ($type == "date") {
                    $string .= '<input type="date" name="'.$field_name.'" class="form-control';
                    if (strlen($field->attributes()->class) > 0)
                    {
                        $string .= ' '. $field->attributes()->class;
                    }
                    if ($value == 0 && $value != $field->attributes()->default)
                    {
                        $value = date("Y-m-d", time());
                    }
                    else if ($value > 0)
                    {
                        $value = date("Y-m-d", $value);
                    }
                    $string .= '" value="'.$value.'"';
                    $string .= '/>';
                } else {
                    $string .= '<textarea name="'.$field_name.'" class="form-control';
                    if (strlen($field->attributes()->class) > 0)
                    {
                        $string .= ' '. $field->attributes()->class;
                    }
                    $string .= '">'.$value.'</textarea>';
                }
                $string .= '</div>';
                $string .= '</div>';
            }
            if ($display_submit)
            {
                $string .= '<button type="submit" class="button float-right no-margin"><i class="fa fa-save"></i> Save</button>';
            }
            $string .= '<div class="clearfix"></div>';
            echo $string;
        }
        
        public function displaySelect($items, $field_name, $current = "", $multiple = false, $class = "", $label = "")
        {
            $string = '<div class="row form-group"><label class="col-md-2 col-form-label">'. (strlen($label) > 0 ? $label : $field_name) .'</label><div class="col-md-10">';
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
                if ($current == $option->value)
                {
                    $string .= 'selected="selected"';
                }
                $string .= '>'.$option->name.'</option>';
            }
            $string .= '</select></div></div>';
            echo $string;
        }
        
        public function displaySql($controller, $name, $current, $db, $label = "")
        {
            $string = '<div class="row form-group"><label class="col-md-2 col-form-label">'. (strlen($label) > 0 ? $label : $controller->attributes()->label) .'</label><div class="col-md-10">';
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
            $string .= '</select></div></div>';
            echo $string;
        }
    }
?>