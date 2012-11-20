<?php
/**
 * Provides general purpose helper methods
 */
class Helper{
    const DIRECTORY_SHORTCUT    = 'd';
    const FILESIZE_SHORTCUT     = 's';
    const HELP_SHORTCUT         = 'help';
    //To be written....
    const HELP_MESSAGE = <<<HELP
Composite.php creates the tree structure of the contents of
a given directory
Usage:
php composite.php -d directory [-s] [--help]\n
HELP;


    
    /**
     * Public static function handleInput
     * Gets options from command line input, using specifies parameters
     * @return array Options array
     */
    public static function hadleInput(){
        //Directory is mandatory, filesize is optional
        $options = self::DIRECTORY_SHORTCUT . ':' . self::FILESIZE_SHORTCUT . '::';
        //Optional parameter help
        $longOptions = array(self::HELP_SHORTCUT . "::");
        
        return getopt($options,$longOptions);
    }
    
    /**
     * Public static function createFileStructure
     * Parses user input and returns response accordingly
     * @param array $options Options from command line input
     * @throws Exception when input is invalid
     * @return mixed output
     *    - string when help is requested
     *    - Node object when the directory is read
     */
    public static function createResponse($options){
        if (!is_array($options)) {
            throw new Exception ('Invalid Input (' . __FUNCTION__ . ')');
            return false;
        }
        // If user needs help, ignore all other input params and show help
        if (isset($options[self::HELP_SHORTCUT])) 
            return self::HELP_MESSAGE;
        
        // Set other params
        if (isset($options[self::DIRECTORY_SHORTCUT])) {
            $realpath = realpath($options[self::DIRECTORY_SHORTCUT]);
            if (!is_dir($realpath))
                throw new Exception('Invalid directory requested \'' . $options[self::DIRECTORY_SHORTCUT] .'\'. Use --help option for function definition.'); 
            else 
                $directory = rtrim ($realpath,DS);
        } else
            $directory = getcwd();
        
        $filesize = isset($options[self::FILESIZE_SHORTCUT]);
        //echo $directory;die();
        return self::createDirectoryStructure($directory,0,$filesize);
    }
    
    /**
     * Public static function createDirectoryStructure
     * Recursive function that creates A Tree structure of the input directory
     * @param string $path The directory path
     * @param integer $depth Depth of root node (We assume that the depth of the first Node is 0)
     * @param boolean $showFileSize Specifies whether the filesizes of contents will be calculated
     * @return Node
     */
    public static function createDirectoryStructure($path,$depth=0,$showFileSize=false){
        if (!($path) || !is_dir($path))
            throw new Exception("Invalid input directory '$path'");


        $root = new Folder($path,$depth,$showFileSize);

        if ($handle = opendir($path)) {
            while (false !== ($item = readdir($handle))) {
                
                //Skipping parent directories
                if ($item != "." && $item != "..") {

                $itemPath = $path . DS . $item;

                // If it's a directory, using Composite
                if (is_dir($itemPath)) {
                    $child = self::createDirectoryStructure($itemPath,$depth+1,$showFileSize);
                    $root->add($child);
                }

                // If it's a file using Leaf
                if (is_file($itemPath))
                    $root->add(new File($itemPath,$depth+1,$showFileSize));
                }
            }
        }
        
        return $root;
    }
}
?>