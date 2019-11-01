# API Platform Events Bundle

[![Coverage Status](https://coveralls.io/repos/github/alanpoulain/ApiPlatformEventsBundle/badge.svg?branch=master)](https://coveralls.io/github/alanpoulain/ApiPlatformEventsBundle?branch=master)
[![GitHub Actions](https://github.com/alanpoulain/ApiPlatformEventsBundle/workflows/CI/badge.svg)](https://github.com/alanpoulain/ApiPlatformEventsBundle/actions?workflow=CI)

Makes [API Platform](https://api-platform.com/) send its own events.

**It supports only GraphQL (for now).**

Please support the [Stages RFC](https://github.com/api-platform/core/pull/2978) if you want a support for REST.

This bundle is useful if you *really* want to use events.
The recommended way to add your logic is to [decorate the stages](https://api-platform.com/docs/core/graphql/#workflow-of-the-resolvers).

With this bundle, the following events will be dispatched during a query or a mutation executed by API Platform:

| Event                | Query      | Mutation |
| -------------------- |:----------:| --------:|
| PreReadEvent         | sent ✔️️     | sent ✔️  |
| PostReadEvent        | sent ✔️     | sent ✔️  |
| PreDeserializeEvent  | not sent ❌ | sent ✔️  |
| PostDeserializeEvent | not sent ❌ | sent ✔️  |
| PreValidateEvent     | not sent ❌ | sent ✔️  |
| PostValidateEvent    | not sent ❌ | sent ✔️  |
| PreWriteEvent        | not sent ❌ | sent ✔️  |
| PostWriteEvent       | not sent ❌ | sent ✔️  |
| PreSerializeEvent    | sent ✔️     | sent ✔️  |
| PostSerializeEvent   | sent ✔️     | sent ✔️  |

By using [Event Listeners](https://symfony.com/doc/current/event_dispatcher.html), you can add your custom logic where you need.

In an event sent by this bundle, you have access to:
- the related resource,
- the operation name (`get`, `delete`, etc.),
- the related data (if it makes sense),
- the context (an array with some useful data).

## Installation

Make sure Composer is installed globally, as explained in the
[installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

### Applications that use Symfony Flex

Open a command console, enter your project directory and execute:

```console
$ composer require alanpoulain/api-platform-events-bundle
```

### Applications that don't use Symfony Flex

#### Step 1: Download the Bundle

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
$ composer require alanpoulain/api-platform-events-bundle
```

#### Step 2: Enable the Bundle

Then, enable the bundle by adding it to the list of registered bundles
in the `config/bundles.php` file of your project:

```php
// config/bundles.php

return [
    // ...
    ApiPlatform\EventsBundle\ApiPlatformEventsBundle::class => ['all' => true],
];
```

## Documentation

For an explanation of how it works, please read the [documentation](Resources/doc/index.md).

## License

This package is available under the [MIT license](LICENSE).
