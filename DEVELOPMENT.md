# Beyonic Php Library

##### Adding new api model
To create new api model you should perform below mentioned steps:
- Create a file under lib/Beyonic folder containing a class for newly added model. See other file there for your reference.
- add import statement in ```lib/Beyonic.phpy``` file. E.g. ```require_once(dirname(__FILE__) . '/Beyonic/Beyonic_Exception.php');```


#### Releasing a new version
To release a new version:
- Increment the version number in lib/Beyonic.php
- Commit and push the code
- Create a tag (release) with the same name as the new version
- Go to https://packagist.org and login and update the Beyonic project to fetch the new files

