<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();

{% if 'index' in actions %}
$collection->add('{{ route_name_prefix }}', new Route('/', array(
    '_controller' => '{{ bundle }}:{{ entity }}:index',
)));
{% endif %}

{% if 'show' in actions %}
$collection->add('{{ route_name_prefix }}_show', new Route('/{id}/show', array(
    '_controller' => '{{ bundle }}:{{ entity }}:show',
)));
{% endif %}

{% if 'new' in actions %}
$collection->add('{{ route_name_prefix }}_new', new Route('/new', array(
    '_controller' => '{{ bundle }}:{{ entity }}:new',
)));

$collection->add('{{ route_name_prefix }}_create', new Route(
    '/create',
    array('_controller' => '{{ bundle }}:{{ entity }}:create'),
    array('_method' => 'post')
));
{% endif %}

{% if 'edit' in actions %}
$collection->add('{{ route_name_prefix }}_edit', new Route('/{id}/edit', array(
    '_controller' => '{{ bundle }}:{{ entity }}:edit',
)));

$collection->add('{{ route_name_prefix }}_update', new Route(
    '/{id}/update',
    array('_controller' => '{{ bundle }}:{{ entity }}:update'),
    array('_method' => 'post')
));
{% endif %}

{% if 'delete' in actions %}
$collection->add('{{ route_name_prefix }}_delete', new Route(
    '/{id}/delete',
    array('_controller' => '{{ bundle }}:{{ entity }}:delete'),
    array('_method' => 'post')
));
{% endif %}

return $collection;
