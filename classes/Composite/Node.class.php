<?php
/**
 * Abstract class Node (Component)
 * Defines Abstract methods for children to implement
 * Provides general helper method
 */
abstract class Node {
    //It should return the size of the object
    abstract function size();
    //It should create descriptive output of the object
    abstract function output();
    
    /**
     * Pad method
     * creates padding, according to input for better representation
     * of the tree structure of the nodes
     * @param integer $level The level/depth of the node
     * @return string
     */
    final public function pad($level = 0){
        $pad = "";
        if ($level === 0) return $pad;
        for ($i=0;$i<$level;$i++)
            $pad .= "\t";
        return $pad;
    }
}
?>
