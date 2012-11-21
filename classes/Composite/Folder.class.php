<?php
require_once 'Node.class.php';
/**
 * Class Folder (composite node)
 * Represents composite objects, stores child components
 * and implements child-related behaviors
 */
class Folder extends Node {
    protected $path,
              $size=0,
              $children,
              $name,
              $showSize;
    
    /**
     * Constructor Mehtod
     * @param string $path Directory path
     * @param int $depth Depth of node in tree structure
     * @param boolean $showSize Whether to show Node size
     */
    public function __construct($path,$depth,$showSize=false) {
        if (!is_dir($path))
            throw new Exception("'$path' is not a valid directory");
        $this->path = $path;
        $this->name = strrchr($path,DS);
        $this->depth = $depth;
        $this->showSize = $showSize;
        parent::__construct($depth);
    }
    
    /**
     * Adds a node to children
     * @param Node $node The node to be added
     */
    public function add(Node $node){
        $this->children[] = $node;
        $this->size = 0;//reset size if already computed, it must be recomputed!
    }
    
    /**
     * Removes a node from children
     * @param Node $node The node to be removed
     */
    public function remove(Node $node){
        $index = array_search($node, $this->children, true);
        if ($index === false)
            return false;
        array_splice($this->children, $index, 1);
        $this->size=0;
        return true;
    }
    /**
     * Computes node size by retrieving it's children's size
     * @return integer The size of the Object
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
     * Returns the array with Object's children
     * @return array The array whith node's children
     */
    public function getChildren(){
        return $this->children;
    }
    
    /**
     * Returns specific Child
     * @param integer $key the key of child in children array
     * @return array of Node objects | Node object | false if object not found
     */
    public function getChild($key){
        if (array_key_exists($key, $this->children))
            return $this->children[$key];
        else
            return false;
    }
}
?>
