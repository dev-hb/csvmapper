<?php

class CSVRecord
{

    /**
     * Create all fields as attributes
     * @param $fields
     * @param $values
     * @return $this
     */
    public function createRecord($fields, $values){
        foreach ($fields as $key=>$field){
            if(is_numeric($values[$key])) $this->{$this->prettify($field)} = $values[$key] + 0;
            else $this->{$this->prettify($field)} = $values[$key];
        } return $this;
    }

    /**
     * Get a single field value
     * @param $field
     * @return mixed
     */
    public function get($field){
        return $this->{$field};
    }

    /**
     * Update a record row
     * @param $field
     * @param string $new_value
     * @return $this
     */
    public function update($field, $new_value = ""){
        $this->{$field} = $new_value;
        return $this;
    }

    /**
     * Create attribute from field name
     * @param $name
     * @return array|string|string[]
     */
    public static function prettify($name){
        $attr = strtolower(str_replace(" ", "_", $name));
        return str_replace("'", "", str_replace("\"", "", str_replace("/", "-", $attr)));
    }



}