MopaBootstrapBundle Twitters Bootstrap integration
==================================================

We decided not to take the twitter/bootstrap distribution into this repo to seperate concerns more efficently.
So you have to include twitter/bootstrap in some manner into your project, here are some examples on howto do it

Since symfony2.1 will use composer (http://www.getcomposer.org) to organize dependencies, it is highly recommended to ease your life to do it the recommended way

## Include in your project composer.json (RECOMMENDED):

### Managing twitter/bootstrap installation automatically

To have composer managing twitter/bootstrap too, you can either run it with
--install-suggests or add the following to your composer.json (recommended):

```json
{
    "require": {
        "mopa/bootstrap-bundle": "dev-master",
        "twitter/bootstrap": "master"
    },
    "repositories": [
        {
            "type": "package",
            "package": {
                "version": "master",
                "name": "twitter/bootstrap",
                "source": {
                    "url": "https://github.com/twitter/bootstrap.git",
                    "type": "git",
                    "reference": "master"
                },
                "dist": {
                    "url": "https://github.com/twitter/bootstrap/zipball/master",
                    "type": "zip"
                 }
            }
        }
    ]
}
```

       
<h2 id="Warning">Warning</h2>
> Composer doesn't install suggests from mopa/boostrap-bundle!
> If you need e.g knplabs menues or paginator, craue/formflow, 
> please add them to YOUR composer.json too!

```json
   {
       "require": {
           "mopa/bootstrap-bundle": "dev-master",
           "twitter/bootstrap": "master",
           "knplabs/knp-paginator-bundle": "dev-master",
           "knplabs/knp-menu-bundle": "dev-master",
           "craue/formflow-bundle": "dev-master"
       },
       "repositories": [
           {
               "type": "package",
               "package": {
                   "version": "master", /* whatever version you want */
                   "name": "twitter/bootstrap",
                   "source": {
                       "url": "https://github.com/twitter/bootstrap.git",
                       "type": "git",
                       "reference": "master"
                   },
                   "dist": {
                       "url": "https://github.com/twitter/bootstrap/zipball/master",
                       "type": "zip"
                   }
               }
           }
       ]
   }
```

To activate auto symlinking and checking after composer update/install add also to your existing scripts:

```json
{
    "scripts": {
        "post-install-cmd": [
            "Mopa\\Bundle\\BootstrapBundle\\Composer\\ScriptHandler::postInstallSymlinkTwitterBootstrap"
        ],
        "post-update-cmd": [
            "Mopa\\Bundle\\BootstrapBundle\\Composer\\ScriptHandler::postInstallSymlinkTwitterBootstrap"
        ]
    }
}
```

For Sass support, you can also use the specific command:

```json
{
    "scripts": {
        "post-install-cmd": [
            "Mopa\\Bundle\\BootstrapBundle\\Composer\\ScriptHandler::postInstallSymlinkTwitterBootstrapSass"
        ],
        "post-update-cmd": [
            "Mopa\\Bundle\\BootstrapBundle\\Composer\\ScriptHandler::postInstallSymlinkTwitterBootstrapSass"
        ]
    }
}
```

## Managing twitters/bootstrap location manually

To manage the location of twitters/bootstrap manually just add in your composer.json:

    ```json
    {
        "require": {
            "mopa/bootstrap-bundle": "dev-master",
        }
    }
    ```
 

**Warning:**

> The path to bootstrap might change depending on how you decide to include it into your project.
> So please be careful when including it in twig, less etc. to have the correct path in mind! 
>
> You have been warned, if your are knowing what you do, don't complain!

### (OLD STYLE) Including as Submodule

You can include twitters bootstrap as a submodule directly by changing into the MopaBootstrapBundle folder and executing:

``` bash
cd vendor/bundles/Mopa/BootstrapBundle
git submodule init
git submodule update
```


### (OLD STYLE) Including Bootstrap as own vendor dependency in deps:

To have bootstrap installed by the vendors script of symfony use the following in your deps file:

```
[TwitterBootstrap2]
    git=git://github.com/twitter/bootstrap.git
    target=/twitter/bootstrap/v2/
    version=v2.0.0
```

### (NOT RECOMMENDED) Including Bootstrap manually

To use bootstrap without less just download the zipped distribution

 http://twitter.github.com/bootstrap/assets/bootstrap.zip
 
 and unpack it e.g.
 
 in app/Resources/public/

