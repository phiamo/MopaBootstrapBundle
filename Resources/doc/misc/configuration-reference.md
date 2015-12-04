Mopa Bootstrap Configuration Reference
=========================================

Default configuration for extension with alias: "mopa_bootstrap"

```yaml
mopa_bootstrap:
    form:
        templating:           MopaBootstrapBundle:Form:fields.html.twig
        horizontal:           true
        horizontal_label_class:  col-sm-3 control-label
        horizontal_label_offset_class:  col-sm-offset-3
        horizontal_input_wrapper_class:  col-sm-9
        render_fieldset:      true
        render_collection_item:  true
        show_legend:          true
        show_child_legend:    false
        checkbox_label:       both
        render_optional_text:  true
        render_required_asterisk:  false
        error_type:           ~
        tabs:
            class:                nav nav-tabs
        help_widget:
            popover:
                title:                ~
                content:              ~
                trigger:              hover
                toggle:               popover
                placement:            right
                selector:             ~
        help_label:
            tooltip:
                title:                ~
                text:                 ~
                icon:                 info-sign
                placement:            top
            popover:
                title:                ~
                content:              ~
                text:                 ~
                icon:                 info-sign
                placement:            top
        collection:
            widget_remove_btn:
                attr:
                    class:                btn btn-default
                label:                remove_item
                icon:                 ~
                icon_inverted:        ~
                wrapper_div:
                    class:            form-group
                horizontal_wrapper_div:
                    class:            col-sm-3 col-sm-offset-3
            widget_add_btn:
                attr:
                    class:                btn btn-default
                label:                add_item
                icon:                 ~
                icon_inverted:        ~

    icons:

        # Icon set to use: ['glyphicons','fontawesome','fontawesome4']
        icon_set:             glyphicons

        # Alias for mopa_bootstrap_icon()
        shortcut:             icon
    menu:
        enabled:              false

        # Menu template to use when rendering
        template:             MopaBootstrapBundle:Menu:menu.html.twig
    initializr:
        meta:
            title:                MopaBootstrapBundle
            description:          MopaBootstrapBundle
            keywords:             MopaBootstrapBundle, Twitter Bootstrap, HTML5 Boilerplate
            author_name:          My name
            author_url:           http://...
            feed_atom:            ~
            feed_rss:             ~
            sitemap:              ~
            nofollow:             false
            noindex:              false
        dns_prefetch:

            # Default:
            - //ajax.googleapis.com
        google:
            wt:                   ~
            analytics:            ~
            extendedanalytics:    false
        diagnostic_mode:      false

    flash:
        mapping:
            # alertType => [flashType1, ..]
            success: [success]
            danger: [error, danger]
            warning: [warning, warn]
            info: [info, notice]
```
