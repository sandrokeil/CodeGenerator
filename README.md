# Code generator for Zend Framework 2

Zend Framework 2 code generator which generates form and input filter depending on database or doctrine 2 meta data.

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
Before you can use these doctrine commands please make sure you have enabled and configured you [cli-config.php](http://docs.doctrine-project.org/en/latest/reference/tools.html#configuration) for
doctrine. For a common example see [cli-config.php](cli-config.php) of this repository.

```
php public/index.php zf2:generate:form [YOUR PATH]
```

## Console Zend Framework 2
