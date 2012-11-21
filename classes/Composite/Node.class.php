<?php
/**
 * Abstract class Node (Component)
 * Defines Abstract methods for children to implement
 * Provides general helper method
 */
abstract class Node {
    protected $depth;
    //It should return the size of the object
    abstract function size();
    //It should create descriptive output of the object
    abstract function output();
    
    /**
     * Constructor method
     * @param integer $depth The depth of node in the tree structure
     */
    public function __construct($depth) {
        if (!is_numeric($depth))
            throw new Exception(__Class__ . "::" . __FUNCTION__ . " Invalid input depth ($depth)");
        
        $this->depth = $depth;
    }

    /**
     * Pad method
     * creates padding, according to depth for better representation
     * of the tree structure of the nodes
     * @return string
     */
    final public function pad(){
        $pad = "";
        
        for ($i=0 ; $i < $this->depth ; $i++)
            $pad .= "\t";
        
        return $pad;
    }
}
?>
