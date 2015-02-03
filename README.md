# magento-di

This provides a tiny module and a couple of hacks that gets Symfony DI integrated (to a point) with Magento core.

## Why?

I was thinking about a conversation I'd had with [Ciaran](https://github.com/ciaranmcnulty). We'd been talking about using Phpspec with Magento, and how we were frequently needing to mock Magento objects. That's something that I've previously accepted as a necessary evil of working with Magento, but I came to thinking that I might be taking the wrong approach.

The code that we should be testing first and foremost is our domain model. If we were to implement DDD principles then we should be representing all the aspects of our domain in code, and there's no reason why any of those objects should be in any way coupled to a specific framework. With this in mind, it makes no sense to place any of that domain code within a Magento code pool, because it is nothing to do with Magento. The existing pattern within Magento for framework agnostic code is to put it in the lib directory, but there's no reason why it shouldn't be a dependency loaded with Composer.

### So why is DI needed?

If we run with the idea of placing our domain model outside of Magento then we are still going to need a thin framework wrapper to use it, and that comes in the form of a Magento module. Within that module would be mainly framework specific objects like controllers and observers, and these would rapidly offload responsibility to our domain model. The danger is that this would create a tight coupling between the module and the domain model's implementation. A way to avoid this is to allow Magento to pull its dependancies from a service container, and only typehint based on interfaces. A better way would be to inject dependencies directly into the Magento objects themselves, but let's not get carried away.

## Installation

- Install the module in the project
- Patch `<magento_root>/public` and `<magento_root>/app/Mage.php` with the changes in `public/index.php` and `public/app/Mage.php` (this repo). 
- Add the following to your `composer.json`:

```json
{
    "require": {
        "symfony/dependency-injection": "2.5.*@stable",
        "symfony/config": "2.5.*@stable"
    }
}
```

- Run `composer install`


## Usage

Services can be defined in `<magento_root>/etc/services.xml` or a module can define its own services with its own `services.xml` (`<module_root>/etc/services.xml`). If a module defines its own services a new node must be added to the modules main config:

```xml
<?xml version="1.0"?>
<config>
    <modules>
        <Foo_Bar>
            <version>0.1.0</version>
        </Foo_Bar>
    </modules>
    <sth_di>
        <Foo_Bar />
    </sth_di>
</config>
```

The new node `<sth_di>` must contain only one node which matches the name of the module.

You can read more about declaring services via XML [here](http://symfony.com/doc/current/components/dependency_injection/introduction.html#setting-up-the-container-with-configuration-files).

## Is this actually useful?

For the average Magento site, no, probably not. It adds an additional layer of complexity that is probably hard to justify in a lot of cases. However, if you are concerned about separating your domain from the framework then this is a viable approach.
