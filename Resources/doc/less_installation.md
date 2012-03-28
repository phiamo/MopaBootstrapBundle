MopaBootstrapBundle Less installation
=====================================

To effectively use all features of bootstrap you might want to use less together with bootstrap.
Have a look into the following docs what it is and then maybe install it on your systems.

[Twitters Less Doc](http://twitter.github.com/bootstrap/less.html)
[Lesscss](http://lesscss.org/)


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

Known Problems:
---------------

If you have problems with your less version 
for istance, less 1.2.1 did not work for me with bootstrap 2.0.2
there was an error like:

```
[RuntimeException]                                                           
  TypeError: Cannot call method 'charAt' of undefined                          
      at getLocation (/usr/lib/node_modules/less/lib/less/parser.js:204:34)    
      at new LessError (/usr/lib/node_modules/less/lib/less/parser.js:213:19)  
      at Object.toCSS (/usr/lib/node_modules/less/lib/less/parser.js:379:31)   
      at /tmp/assetic_lessXmx8n9:11:24                                         
      at /usr/lib/node_modules/less/lib/less/parser.js:428:40                  
      at /usr/lib/node_modules/less/lib/less/parser.js:94:48                   
      at /usr/lib/node_modules/less/lib/less/index.js:113:15                   
      at /usr/lib/node_modules/less/lib/less/parser.js:428:40                  
      at /usr/lib/node_modules/less/lib/less/parser.js:94:48                   
      at /usr/lib/node_modules/less/lib/less/index.js:113:15  
```

another error i had was 

```
  [RuntimeException]                                                                                                                                                                         
  Syntax Error on line 396 in /var/www/virtual/mohrenweiserpartner.de/bootstrap/checkout/vendor/bundles/Mopa/BootstrapBundle/Resources/bootstrap/less/mixins.less        
  395 .reset-filter() {                                                                                                                                                            
  396   filter: progid:DXImageTransform.Microsoft.gradient(enabled = false);                                                                                              
  397 }                            
```

To solve it , i installed a own copy of the less master (currently 1.3.0):

```bash
sudo git clone https://github.com/cloudhead/less.js.git /opt/lessc
```

and added in config.yml the path before the std path:

```yaml
# Assetic Configuration
assetic:
    debug:          %kernel.debug%
    use_controller: false
    # java: /usr/bin/java
    filters:
        less:
            node: /usr/bin/node
            node_paths: [/opt/lessc/lib, /usr/lib/node_modules] 
    # more to be here, truncated...

```

