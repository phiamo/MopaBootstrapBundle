Mopa Bootstrap Configuration Reference
=========================================

Default configuration for extension with alias: "mopa_bootstrap"

```yaml
mopa_bootstrap:
    version:                            ~
    form:
        templating:                     MopaBootstrapBundle:Form:fields.html.twig
        horizontal_label_class:         col-lg-3
        horizontal_input_wrapper_class: col-lg-9
        render_fieldset:                true
        render_collection_item:         true
        show_legend:                    true
        show_child_legend:              false
        checkbox_label:                 both
        render_optional_text:           true
        render_required_asterisk:       false
        error_type:                     ~
        tooltip:
            icon:                       icon-info-sign
            placement:                  top
        tabs:
            class:                      nav nav-tabs
        popover:
            icon:                       icon-info-sign
            placement:                  top
        collection:
            widget_remove_btn:
                attr:
                    class:              btn
                icon:                   ~
                icon_color:             ~
            widget_add_btn:
                attr:
                    class:              btn
                icon:                   ~
                icon_color:             ~
    navbar:
        enabled:                        false
    initializr:
        meta:
            title:                      MopaBootstrapBundle
            description:                MopaBootstrapBundle
            keywords:                   MopaBootstrapBundle, Twitter Bootstrap, HTML5 Boilerplate
            author_name:                My name
            author_url:                 #
            feed_atom:                  ~
            feed_rss:                   ~
            sitemap:                    ~
            nofollow:                   false
            noindex:                    false
        dns_prefetch:

            # Default:
            - //ajax.googleapis.com
        google:
            wt:                   ~
            analytics:            ~
        diagnostic_mode:          false
```