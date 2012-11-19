<?php
/**
 * Abstract class Node (Component)
 * Defines Abstract methods for children to implement
 * Provides general helper method
 */
abstract class Node {
    abstract function add(Node $node);
    abstract function remove(Node $node);
    abstract function output();
    abstract function size();
    
    public function pad($level = 0){
        $pad = "";
        if (!$level) return $pad;
        for ($i=0;$i<$level;$i++)
            $pad .= "\t";
        return $pad;
    }
}

/**
 * Class File (Leaf)
 */
class File extends Node {
    protected $path,
              $size,
              $depth,
              $name,
              $showSize;
    
    /**
     * Constructor method
     * @param string $path File path
     * @param integer $depth Depth of file in tree structure
     * @param boolean $size Whether to calculate and show size
     */
    public function __construct($path,$depth,$showSize) {
        if (!file_exists($path))
            throw new Exception("File '$path' does not exist");
        $this->path = $path;
        $this->depth = $depth;
        $this->name = ltrim(strrchr($path,DS),DS);
        $this->showSize = $showSize;
        // If size is not needed for display it is not calculated
        if ($this->showSize)
            $this->size = filesize($path);
    }
    
    //No use here, consider removal
    public function add(Node $file){
        return $file;
    }
    //No use here, consider removal (also from parent)
    public function remove(Node $file){
        return true;
    }
    public function size(){
        return $this->size;
    }
    public function output(){
        echo ($this->showSize ? str_pad($this->size(), 20) : '') . $this->pad($this->depth) ."{$this->name}\n";
    }
}

/**
 * Class Folder (composite node)
 */
class Folder extends Node {
    protected $path;
    protected $depth;
    protected $size=0;
    protected $children;
    protected $name;
    protected $showSize;
    
    /**
     * Constructor Class
     * @param string $path Directory path
     * @param int $depth Depth of node in tree structure
     * @param boolean $showSize Whether to show Node size
     */
    public function __construct($path,$depth=0,$showSize=false) {
        if (!is_dir($path))
            throw new Exception("'$path' is not a valid directory");
        $this->path = $path;
        $this->name = strrchr($path,DS);
        $this->depth = $depth;
        $this->showSize = $showSize;
    }
    
    /**
     * Adds a new node
     */
    public function add(Node $node){
        $this->children[] = $node;
        $this->size = 0;//reset size if already computed, it must be recomputed!
    }
    
    public function remove(Node $node){
//        $index = array_search($node, $this->children, true);
//        if ($index === false) {
//            return false;
//        }
//        array_splice($this->children, $index, 1);
//        return true;
    }
    /**
     * Computes node size by retrieving it's children's size
     */
    public function size(){
        if ($this->size === 0) {
            foreach ($this->children as $child)
                $this->size += $child->size();
        }
        return $this->size;
    }
    /**
     * Outputs Node and it's contents
     */
    public function output(){
        echo ($this->showSize ? str_pad($this->size(), 20) : '') . $this->pad($this->depth) . "{$this->name}\n";
        foreach ($this->children as $child)
            echo $child->output();
    }
    /**
     * @return array The array whith node's children
     */
    public function showChildren(){
        return $this->children;
    }
}

?>
