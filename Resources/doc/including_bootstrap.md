MopaBootstrapBundle Twitters Bootstrap integration
==================================================

We decided not to take the bootstrap distribution into this repo to seperate concerns more efficently.
So you have to include bootstrap in some manner into your project, here are some examples on howto do it:


### (RECOMMENDED) Include in your project composer.json / composer.lock:

Since symfony2.1 will use composer (http://www.getcomposer.org) to organize dependencies, 
it is highly recommended to ease your life to do it this way:

Add in your composer.json:

```json
{
    "require": {
        "mopa/bootstrap-bundle": "dev-master",
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
            "Mopa\\BootstrapBundle\\Composer\\ScriptHandler::postInstallSymlinkTwitterBootstrap"
        ],
        "post-update-cmd": [
            "Mopa\\BootstrapBundle\\Composer\\ScriptHandler::postInstallSymlinkTwitterBootstrap"
        ]
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

