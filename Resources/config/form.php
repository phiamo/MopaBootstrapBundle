<?php

/*
 * This file is part of the MopaBootstrapBundle.
 *
 * (c) Philipp A. Mohrenweiser <phiamo@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Mopa\Bundle\BootstrapBundle\Form\Extension\DateTypeExtension;
use Mopa\Bundle\BootstrapBundle\Form\Extension\DatetimeTypeExtension;
use Mopa\Bundle\BootstrapBundle\Form\Extension\EmbedFormExtension;
use Mopa\Bundle\BootstrapBundle\Form\Extension\ErrorTypeFormTypeExtension;
use Mopa\Bundle\BootstrapBundle\Form\Extension\HelpFormTypeExtension;
use Mopa\Bundle\BootstrapBundle\Form\Extension\IconButtonExtension;
use Mopa\Bundle\BootstrapBundle\Form\Extension\LayoutFormTypeExtension;
use Mopa\Bundle\BootstrapBundle\Form\Extension\LegendFormTypeExtension;
use Mopa\Bundle\BootstrapBundle\Form\Extension\OffsetButtonExtension;
use Mopa\Bundle\BootstrapBundle\Form\Extension\StaticTextExtension;
use Mopa\Bundle\BootstrapBundle\Form\Extension\TabbedFormTypeExtension;
use Mopa\Bundle\BootstrapBundle\Form\Extension\TimeTypeExtension;
use Mopa\Bundle\BootstrapBundle\Form\Extension\WidgetCollectionFormTypeExtension;
use Mopa\Bundle\BootstrapBundle\Form\Extension\WidgetFormTypeExtension;
use Mopa\Bundle\BootstrapBundle\Form\Type\FormActionsType;
use Mopa\Bundle\BootstrapBundle\Form\Type\TabType;

return static function (ContainerConfigurator $container): void {
    $services = $container->services();

    $services->set('mopa_bootstrap.form.type_extension.embed_form', EmbedFormExtension::class)
        ->tag('form.type_extension');

    $services->set('mopa_bootstrap.form.type_extension.static_text', StaticTextExtension::class)
        ->tag('form.type_extension');

    $services->set('mopa_bootstrap.form.type_extension.offset_button', OffsetButtonExtension::class)
        ->tag('form.type_extension');

    $services->set('mopa_bootstrap.form.type_extension.button', IconButtonExtension::class)
        ->tag('form.type_extension');

    $services->set('mopa_bootstrap.form.type_extension.help', HelpFormTypeExtension::class)
        ->args([[
            'help_block_tooltip' => param('mopa_bootstrap.form.help_block.tooltip'),
            'help_block_popover' => param('mopa_bootstrap.form.help_block.popover'),
            'help_label_tooltip' => param('mopa_bootstrap.form.help_label.tooltip'),
            'help_label_popover' => param('mopa_bootstrap.form.help_label.popover'),
            'help_widget_popover' => param('mopa_bootstrap.form.help_widget.popover'),
        ]])
        ->tag('form.type_extension');

    $services->set('mopa_bootstrap.form.type_extension.legend', LegendFormTypeExtension::class)
        ->args([[
            'render_fieldset' => param('mopa_bootstrap.form.render_fieldset'),
            'show_legend' => param('mopa_bootstrap.form.show_legend'),
            'show_child_legend' => param('mopa_bootstrap.form.show_child_legend'),
            'legend_tag' => param('mopa_bootstrap.form.legend_tag'),
            'render_required_asterisk' => param('mopa_bootstrap.form.render_required_asterisk'),
            'render_optional_text' => param('mopa_bootstrap.form.render_optional_text'),
        ]])
        ->tag('form.type_extension');

    $services->set('mopa_bootstrap.form.type_extension.error', ErrorTypeFormTypeExtension::class)
        ->args([[
            'error_type' => param('mopa_bootstrap.form.error_type'),
        ]])
        ->tag('form.type_extension');

    $services->set('mopa_bootstrap.form.type_extension.widget', WidgetFormTypeExtension::class)
        ->args([[
            'checkbox_label' => param('mopa_bootstrap.form.checkbox_label'),
        ]])
        ->tag('form.type_extension');

    $services->set('mopa_bootstrap.form.type_extension.horizontal', LayoutFormTypeExtension::class)
        ->args([[
            'layout' => param('mopa_bootstrap.form.layout'),
            'horizontal_label_class' => param('mopa_bootstrap.form.horizontal_label_class'),
            'horizontal_label_div_class' => param('mopa_bootstrap.form.horizontal_label_div_class'),
            'horizontal_label_offset_class' => param('mopa_bootstrap.form.horizontal_label_offset_class'),
            'horizontal_input_wrapper_class' => param('mopa_bootstrap.form.horizontal_input_wrapper_class'),
        ]])
        ->tag('form.type_extension');

    $services->set('mopa_bootstrap.form.type_extension.widget_collection', WidgetCollectionFormTypeExtension::class)
        ->args([[
            'render_collection_item' => param('mopa_bootstrap.form.render_collection_item'),
            'widget_add_btn' => param('mopa_bootstrap.form.collection.widget_add_btn'),
            'widget_remove_btn' => param('mopa_bootstrap.form.collection.widget_remove_btn'),
        ]])
        ->tag('form.type_extension');

    $services->set('mopa_bootstrap.form.type_extension.date', DateTypeExtension::class)
        ->args([[
            'date_wrapper_class' => [
                'year' => param('mopa_bootstrap.form.date_wrapper_class.year'),
                'month' => param('mopa_bootstrap.form.date_wrapper_class.month'),
                'day' => param('mopa_bootstrap.form.date_wrapper_class.day'),
            ],
        ]])
        ->tag('form.type_extension');

    $services->set('mopa_bootstrap.form.type_extension.datetime', DatetimeTypeExtension::class)
        ->tag('form.type_extension');

    $services->set('mopa_bootstrap.form.type_extension.time', TimeTypeExtension::class)
        ->tag('form.type_extension');

    $services->set('mopa_bootstrap.form.type_extension.tabbed', TabbedFormTypeExtension::class)
        ->args([
            service('form.factory'),
            ['class' => param('mopa_bootstrap.form.tabs.class')],
        ])
        ->tag('form.type_extension');

    $services->set('mopa_bootstrap.form.type.tab', TabType::class)
        ->tag('form.type');

    $services->set('mopa_bootstrap.form.type.form_actions', FormActionsType::class)
        ->tag('form.type');
};
