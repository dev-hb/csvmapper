<?php

class File {

    /**
     * @var $filename string
     */
    private $filename;
    /**
     * @var $content array
     */
    private $content;
    /**
     * @var $dir string
     */
    private $dir;
    /**
     * @var $fields array
     */
    private $fields;

    /**
     * Creates a new files with all records
     */
    public function __construct($filename, $dir = "data/"){
        $this->dir = $dir;
        $this->filename = $filename;
        $this->content = [];
    }

    /**
     * Load data as CSV Records
     * @return File
     */
    public function parse(){
        global $SEPARATOR;
        try{
            $content = explode(PHP_EOL, $this->getFileContent($this->filename));
            $fields_raw = explode($SEPARATOR, $content[0]);
            $this->fields = $fields_raw;
            unset($content[0]);
            foreach ($content as $row){
                if(trim($row) != "" && count(explode($SEPARATOR, $row)) == count($fields_raw)){
                    $this->content[] = (new CSVRecord())->createRecord($fields_raw, explode($SEPARATOR, $row));
                }
            }
        }catch (Exception $ex){
            echo "The file you provided was not found!";
            die($ex->getMessage());
        }
        return $this;
    }

    /**
     * Save the parsed data as CSV file
     */
    public function save(){
        global $SEPARATOR;
        $file = fopen($this->dir . $this->filename, "a+");
        fputcsv($file, $this->fields, $SEPARATOR);
        var_dump(count($this->getContent()));
        foreach ($this->getContent() as $record){
            $values = [];
            foreach ($this->fields as $field){
                $values[] = $record->{CSVRecord::prettify($field)};
            }
            fputcsv($file, $values, $SEPARATOR);
        }
        fclose($file);
        return $this->filename;
    }

    /**
     * Get file content
     * @throws Exception
     */
    public function getFileContent($filename = null){
        if($filename == null) throw new Exception();
        return file_get_contents($filename);
    }

    /**
     * Add a single record to the list
     * @param $record
     * @return $this
     */
    public function add($record){
        $this->content[] = $record;
        return $this;
    }

    /**
     * Find a single record in the list
     * @param $handle
     * @param $value
     * @return CSVRecord|null
     */
    public function find($handle, $value){
        foreach ($this->content as $record){
            if($record->{CSVRecord::prettify($handle)} == $value) return $record;
        } return null;
    }

    /**
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @param string $filename
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
    }

    /**
     * @return string
     */
    public function getDir()
    {
        return $this->dir;
    }

    /**
     * @param string $dir
     */
    public function setDir($dir)
    {
        $this->dir = $dir;
    }

    /**
     * @return array
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param array $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @param array $fields
     */
    public function setFields($fields)
    {
        $this->fields = $fields;
    }

    /**
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }

}