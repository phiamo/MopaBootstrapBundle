MopaBootstrapBundle Less installation
=====================================

To effectively use all features of bootstrap you might want to use less together with bootstrap.
Have a look into the following docs what it is and then maybe install it on your systems.

[Twitters Less Doc](http://twitter.github.com/bootstrap/less.html)
[Lessscss](http://lesscss.org/)


Install nodejs and less css manually
------------------------------------

 - node.js: https://github.com/joyent/node/wiki/Installation
 - npm: (node package manager) 
 
``` bash
curl http://npmjs.org/install.sh | sh
```

 - less css:

``` bash
npm install less -g
```

 - configure assetic to make use of it (replace /usr with your prefix)

``` yaml
assetic:
    filters:
        less:
            node: /usr/bin/node
            node_paths: [/usr/lib/node_modules]
```

 - Yui CSS and CSS Embed are quite nice, but just additional,
   to make full use of bootstraps capabilites they are not needed, neither is less but its up to you

