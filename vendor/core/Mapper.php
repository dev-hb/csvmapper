<?php

class Mapper {

    /**
     * @var $source1 File
     */
    private $source1;
    /**
     * @var $source2 file
     */
    private $source2;
    /**
     * @var $handle string
     */
    private $handle;
    /**
     * @var string[]
     */
    private $mapping_fields = [];
    /**
     * @var $output File
     */
    private $output;

    /**
     * Create mapper
     * @param $handle
     * @param $source1
     * @param $source2
     * @param $map
     */
    public function __construct($handle, $source1, $source2, $map)
    {
        foreach ($map as $k=>$v){
            $this->mapping_fields[CSVRecord::prettify($k)] = CSVRecord::prettify($v);
        }
        $this->handle = $handle;
        $this->source1 = $source1;
        $this->source2 = $source2;
    }

    /**
     * Map and return resulting file
     * @return File
     */
    public function map(){
        $output_filename = "output-" . (new DateTime('now'))->format('Y-m-d-H-i-s') . ".csv";
        if(! file_exists(OUTPUT_DIR . $output_filename)){
            file_put_contents(OUTPUT_DIR . $output_filename, "");
        }
        $result = new File($output_filename, OUTPUT_DIR);
        $result->setFields($this->source1->getFields());
        foreach ($this->source1->getContent() as $row1){
            foreach ($this->mapping_fields as $key=>$mapping_field){
                if(trim($row1->{CSVRecord::prettify($key)}) == ""){
                    $value_for_handle = $row1->{CSVRecord::prettify($this->handle)};
                    $value_from_source2 = $this->getRecordFromHandle($value_for_handle);
                    if($value_from_source2 instanceof  CSVRecord){
                        $row1->update($key, $value_from_source2->{CSVRecord::prettify($mapping_field)});
                    }
                }
            }
            $result->add($row1);
        }
        return $result;
    }

    /**
     * @param $value
     * @return CSVRecord|null
     */
    public function getRecordFromHandle($value){
        return $this->source2->find($this->handle, $value);
    }
}