<?php
require_once 'Node.class.php';
/**
 * Class Folder (composite node)
 * Represents composite objects, stores child components
 * and implements child-related behaviors
 */
class Folder extends Node {
    protected $path,
              $depth,
              $size=0,
              $children,
              $name,
              $showSize;
    
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
     * Adds a new node to the object
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
            if (is_array($this->children) && count($this->children))
                foreach ($this->children as $child)
                    $this->size += $child->size();
        }
        return $this->size;
    }
    /**
     * Outputs Node and it's contents
     */
    public function output(){
        echo ($this->showSize ? str_pad($this->size(), 10, ' ', STR_PAD_LEFT) . ' ' : '') . $this->pad($this->depth) . "{$this->name}\n";
        if (is_array($this->children) && count($this->children))
            foreach ($this->children as $child)
                echo $child->output();
    }
    /**
     * @return array The array whith node's children
     */
    public function getChildren(){
        return $this->children;
    }
}
?>
