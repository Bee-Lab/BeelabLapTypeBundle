BeelabLapTypeBundle Documentation
=================================

### 1. Installation

Run from terminal:

```bash
$ composer require beelab/lap-type-bundle
```

Enable bundle in the kernel:

```php
<?php
// app/AppKernel.php
public function registerBundles()
{
    $bundles = array(
        // ...
        new Beelab\LapTypeBundle\BeelabLapTypeBundle(),
    );
}
```

### 2. Configuration

Insert in main configuration:

```yaml
# app/config/config.yml

twig:
    form:
        resources:
            - 'BeelabLapTypeBundle::lap_widget.html.twig'
```

Since inputs are pretty large by default, you can use something like this in your stylesheet:

```css
.lap input {
    max-width: 70px;
}
```

### 3. Usage in forms

You can use the ``beelab_lap`` type in your forms. It will displays four number inputs for hours, minutes,
seconds and milliseconds. You can hide hours and/or milliseconds passing the options ``with_hours`` and/or
``with_milliseconds`` with value ``false`` (default values are ``true``).
The submitted value will be converted into an integer (the total milliseconds), so if you want to store that
value in a Doctrine entity, you can use an ``integer`` column type.

### 4. Template filter

You can use the ``lap`` filter to nicely display your lap times (likely coming from a Doctrine entity).
Example:

```jinja
{# your twig template #}
{% block body %}
    {# will show something like 01:23:45.678 #}
    Lap time: {{ entity.time|lap }}

    {# will show something like 23:45.678 #}
    Lap time without hours: {{ entity.time|lap(false) }}
{% endblock %}
```
