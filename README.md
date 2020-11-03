# settings-bundle

Settings bundle for Symfony 5.1+ and PHP 7.4+

## How to install it on Symfony 5.1+ application

First of all, we will need a symfony 5.1 startup application, let's say [symfony-standard edition
with composer](https://symfony.com/doc/current/best_practices/creating-the-project.html)

- `composer create-project symfony/skeleton [project name]`

Now let's add the **longitude-one/settings-bundle**

You can find the doctrine-extensions project on packagist: https://packagist.org/packages/longitude-one/settings-bundle

To add it to your project: 
- `composer require longitude-one/settings-bundle`

## How to map it on Symfony 5.1+ application

Let's start from the mapping. You will need to map this classes for your ORM to be aware of. 
To do so, add some mapping info to your doctrine.orm configuration, edit `config/packages/doctrine.yaml`:

```yaml
doctrine:
    dbal:
# your dbal config here

    orm:
        auto_generate_proxy_classes: %kernel.debug%
        auto_mapping: true
# only these lines are added additionally
        mappings:
            settings:
                type: annotation
                alias: Settings
                prefix: LongitudeOne\SettingsBundle\Entity
                # make sure vendor library location is correct
                dir: "%kernel.project_dir%/vendor/longitude-one/settings-bundle/src/LongitudeOne/Entity"
```

After that, running `symfony console doctrine:mapping:info` you should see the output:

```
 Found xx mapped entities:

 [OK]   App\Entity\... #Entities of your own entities
 ...
 [OK]   LongitudeOne\SettingsBundle\Entity\Settings
```

## How to use the settings in your application?

### How to create a settings?

You only have to create an object and to persist it.

```php
namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;use LongitudeOne\SettingsBundle\Entity\Settings;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FooController  extends AbstractController
{
    public function create(EntityManagerInterface $entityManager)
    {
        $bar = '42'; //$bar can be an array, an object or anything that can be serialized. 
        $settings = new Settings();
        $settings->setCode('foo');
        $settings->setValue($bar);

        $entityManager->persist($settings);
        $entityManager->flush();
    }
}
```

### How to retrieve a value in a controller

First, you need to add the directory of this bundle to the list of Symfony's autowired services.
Edit `config/services.yaml`:

```yaml
# these lines are the default one
parameters:

services:
    # default configuration for services in *this* file
    _defaults:
        autowire: true      # Automatically injects dependencies in your services.
        autoconfigure: true # Automatically registers your services as commands, event subscribers, etc.

    # makes classes in src/ available to be used as services
    # this creates a service per class whose id is the fully-qualified class name
    App\:
        resource: '../src/'
        exclude:
            - '../src/DependencyInjection/'
            - '../src/Entity/'
            - '../src/Kernel.php'
            - '../src/Tests/'

# only the below lines are added
    LongitudeOne\SettingsBundle\:
        resource: '../vendor/longitude-one/settings-bundle/src/LongitudeOne/'
        exclude:
            - '../vendor/longitude-one/settings-bundle/src/LongitudeOne/Entity/'
            - '../vendor/longitude-one/settings-bundle/src/LongitudeOne/Exception/'
```

Now you're able to call the settings interface in your own controller and in your own services:

```php
namespace App\Controller;

use LongitudeOne\SettingsBundle\Service\SettingsInterface;use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FooController  extends AbstractController
{
    public function getValue(SettingsInterface $settingsManager)
    {
        $value = $settingsManager->getValue('foo');
        //...
    }
}
```

If the `foo` settings doesn't exist, a SettingsException will be thrown.

### How to retrieve a value in a service

First, you need to add the directory of this bundle to the list of Symfony's autowired services.
The previous paragraph explain how to do it.

Now, you can use the dependency injection abilities in your services.

```php
namespace App\Service;

use LongitudeOne\SettingsBundle\Service\SettingsInterface;

class FooService
{
    private SettingsInterface $settings;
    
    public function __construct(SettingsInterface $settings) {
        $this->settings=$settings;
    }

    public function someMethod()
    {
        //...
        $value = $this->settings->getValue('foo');
        //...
    }
}
```

If the `foo` settings doesn't exist, a SettingsException will be thrown.

### How to retrieve a value in a twig template

First, you need to add the directory of this bundle to the list of Symfony's autowired services.
The previous paragraph explain how to do it.

Now, you can use the `settings` filter and the `settings` function to retrieve your application settings.

```twig
    {{ dump('foo'|settings) }}

    {{ dump(settings('foo')) }}
```

