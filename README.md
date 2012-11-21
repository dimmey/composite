Project Composite
==================

##Description
Using Composite Design Pattern to built the tree structure of the file system starting from an input directory

##Usage
You can execute the script through your terminal

`php composite.php -d directory [-s] [--help]`

**Examples**

    dimitris@ubuntu:~/sites/composite$ php composite.php -d classes/ -s
    
    9033 /classes
    3668   /Helpers
    3668 		Helper.class.php
    5365 	/Composite
    1504 		File.class.php
    1024 		Node.class.php
    2837 		Folder.class.php
The directory can be a relative path

    dimitris@ubuntu:~/sites/composite$ php composite.php -d /home/sites/composite/classes/ -s
    
    9033 /classes
    3668   /Helpers
    3668   	Helper.class.php
    5365 	/Composite
    1504 		File.class.php
    1024 		Node.class.php
    2837 		Folder.class.php
Or it can be an absolute path


    dimitris@ubuntu:~/sites/composite$ php composite.php
    /composite
          README.md
          /classes
             /Helpers
               Helper.class.php
           	 /Composite
           		File.class.php
           		Node.class.php
           		Folder.class.php
          composite.php
Without any params the current directory is listed


