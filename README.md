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
To do so, add some mapping info to your doctrine.orm configuration, edit `config/doctrine.yaml`:

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
                dir: "%kernel.root_dir%/../vendor/longitude-one/settings-bundle/src/LongitudeOne/Entity"
```

After that, running `symfony console doctrine:mapping:info` you should see the output:

```

```