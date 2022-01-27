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
        try{
            $content = explode(PHP_EOL, $this->getFileContent($this->filename));
            $fields_raw = explode(";", $content[0]);
            $this->fields = $fields_raw;
            unset($content[0]);
            foreach ($content as $row){
                if(trim($row) != "" && count(explode(";", $row)) == count($fields_raw)){
                    $this->content[] = (new CSVRecord())->createRecord($fields_raw, explode(";", $row));
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
        $file = fopen($this->dir . $this->filename, "a+");
        fputcsv($file, $this->fields, ";");
        var_dump(count($this->getContent()));
        foreach ($this->getContent() as $record){
            $values = [];
            foreach ($this->fields as $field){
                $values[] = $record->{CSVRecord::prettify($field)};
            }
            fputcsv($file, $values, ";");
        }
        fclose($file);
    }

    /**
     * Get file content
     * @throws Exception
     */
    public function getFileContent($filename){
        if(! file_exists($this->dir . $filename)) throw new Exception();
        return file_get_contents($this->dir . $filename);
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