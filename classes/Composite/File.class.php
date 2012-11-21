<?php
require_once 'Node.class.php';
/**
 * Class File (Leaf)
 * Represent Leaf objects in the composition
 * and defines behaviors for them
 */
class File extends Node {
    protected $path,
              $size,
              $name,
              $showSize;
    
    /**
     * Constructor method
     * @param string $path File path
     * @param integer $depth Depth of file in tree structure
     * @param boolean $showSize Whether to calculate and show size
     */
    public function __construct($path,$depth,$showSize) {
        if (!file_exists($path))
            throw new Exception("File '$path' does not exist");
        
        $this->path = $path;
        $this->name = ltrim(strrchr($path,DS),DS);
        $this->showSize = $showSize;
        // If size is not needed for display it is not calculated
        if ($this->showSize)
            $this->size = filesize($path);
        
        parent::__construct($depth);
    }
    
    /**
     * Returns size of file
     * @return integer Size of File | NULL when size is not set
     */
    public function size(){
        return $this->size;
    }
    
    /**
     * Outputs the File information
     * Format:
     *  - Size of file in bytes (if showSize is set)
     *  - N tabs, where N = depth of File in the tree structure
     *  - File Name
     */
    public function output(){
        echo ($this->showSize ? str_pad($this->size(), 10,' ', STR_PAD_LEFT) . ' ' : '') . $this->pad($this->depth) . "{$this->name}\n";
    }
}
?>
