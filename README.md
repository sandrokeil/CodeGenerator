# Code generator for Zend Framework 2

>You want to concentrate on the important things in your project and do not waste time with standard goodies?

>You want surefire input filter and forms depending on your database or doctrine 2 meta data?

>You want forms and input filter that are universally used and combined?

>This module comes to the rescue!

[![Build Status](https://travis-ci.org/sandrokeil/CodeGenerator.png?branch=master)](https://travis-ci.org/sandrokeil/CodeGenerator)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/sandrokeil/CodeGenerator/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/sandrokeil/CodeGenerator/?branch=master)
[![Coverage Status](https://coveralls.io/repos/sandrokeil/CodeGenerator/badge.png)](https://coveralls.io/r/sandrokeil/CodeGenerator)
[![HHVM Status](http://hhvm.h4cc.de/badge/sandrokeil/code-generator.svg)](http://hhvm.h4cc.de/package/sandrokeil/code-generator)
[![Latest Stable Version](https://poser.pugx.org/sandrokeil/code-generator/v/stable.png)](https://packagist.org/packages/sandrokeil/code-generator)
[![Dependency Status](https://www.versioneye.com/user/projects/540371b0eab62a132800014a/badge.svg)](https://www.versioneye.com/user/projects/540371b0eab62a132800014a)
[![Total Downloads](https://poser.pugx.org/sandrokeil/code-generator/downloads.png)](https://packagist.org/packages/sandrokeil/code-generator)
[![License](https://poser.pugx.org/sandrokeil/code-generator/license.png)](https://packagist.org/packages/sandrokeil/code-generator)


Zend Framework 2 code generator which generates form and input filter depending on database or doctrine 2 meta data. Create new forms and input filter in seconds with your namespace and parent class.


 * **Great foundations.** Based on [Zend Framework 2](https://github.com/zendframework/zf2) and [Doctrine 2](https://github.com/doctrine/doctrine2)
 * **Every change is tracked**. Want to know whats new? Take a look at [CHANGELOG.md](CHANGELOG.md)
 * **Listen to your ideas.** Have a great idea? Bring your tested pull request or open a new issue. See [CONTRIBUTING.md](CONTRIBUTING.md)

## Installation

Installation of this module uses composer. For composer documentation, please refer to
[getcomposer.org](http://getcomposer.org/).

Put the following into your composer.json

    {
        "require": {
            "sandrokeil/code-generator": "dev-master"
        }
    }

Then add `Sake\CodeGenerator` to your `./config/application.config.php`.

## Documentation

## Console Doctrine 2
Before you can use these doctrine commands please make sure you have enabled and configured your [cli-config.php](http://docs.doctrine-project.org/en/latest/reference/tools.html#configuration) for
doctrine. For a common example see [cli-config.php](cli-config.php) of this repository.

```
zf:generate-form [--filter="..."] [--force] [--from-database] [--extend[="..."]] [--namespace[="..."]] [--num-spaces[="..."]] dest-path
```

## Console Zend Framework 2
