TwigExtraBundle
=================
[![Build Status](https://secure.travis-ci.org/taavit/TwigExtraBundle.png)](http://travis-ci.org/taavit/TwigExtraBundle)


##Installation via composer
  Update your composer.json
  ```json
  {
     "require":
       {
         "taavit/TwigExtraBundle": "dev-master"
       }
  }
  ```

  composer.phar update taavit/TwigExtraBundle

  Update your AppKernel.php 
  ```php
  public function registerBundles()
  {
      return array(
          // ...
          new Taavit\TwigExtraBundle\TwigExtraBundle(),
          // ...
      );
  }
  ```
##Usage

To your DateTime object in twig (created,updated) you simply add '|prettify'. 
Example:
  ```twig
  {{comment.created|prettify}} 
  ```
  and you will get nice formated when comment was added (5 days ago, yesterday, One year ago)
