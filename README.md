# magento-di

This is a very WIP application of the Symfony DI container within Magento

## Why?

### Because I got drunk.

I was thinking about a conversation I'd had with [Ciaran](https://github.com/ciaranmcnulty). We'd been talking about using Phpspec with Magento, and how we were frequently needing to mock Magento objects. That's something that I've previously accepted as a necessary evil of working with Magento, but I came to thinking that I might be taking the wrong approach.

The code that we should be testing first and foremost is our domain model. If we were to implement DDD principles then we should be representing all the aspects of our domain in code, and there's no reason why any of those objects should be in any way coupled to a specific framework. With this in mind, it makes no sense to place any of that domain code within a Magento code pool, because it is nothing to do with Magento. The existing pattern within Magento for framework agnostic code is to put it in the lib directory, but there's no reason why it shouldn't be a dependency loaded with Composer.

### So why is DI needed?

If we run with the idea of placing our domain model outside of Magento then we are still going to need a thin framework wrapper to use it, and that comes in the form of a Magento module. Within that module would be mainly framework specific objects like controllers and observers, and these would rapidly offload responsibility to our domain model. The danger is that this would create a tight coupling between the module and the domain model's implementation. A way to avoid this is to allow Magento to pull its dependancies from a service container, and only typehint based on interfaces. A better way would be to inject dependencies directly into the Magento objects themselves, but let's not get carried away.

## Installation

Install the module as normal. The implementation also requires that changes are made to public/index.php and public/app/Mage.php. Then run Composer.

## Is this actually useful?

I have no idea yet. It all sounds reasonable on paper, but there may be massive drawbacks, or something I've not thought of yet that makes the whole concept redundant. It'll be fun finding out.
