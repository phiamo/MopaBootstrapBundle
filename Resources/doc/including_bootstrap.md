MopaBootstrapBundle Twitters Bootstrap integration
==================================================

We decided not to take the bootstrap distribution into this repo to seperate concerns more efficently.
So you have to include bootstrap in some manner into your project, here are some examples on howto do it:


**Warning:**

> The path to bootstrap might change depending on how you decide to include it into your project.
> So please be careful when including it in twig, less etc. to have the correct path in mind! 

### Including as Submodule

You can include twitters bootstrap as a submodule directly by changing into the MopaBootstrapBundle folder and executing:

``` bash
cd vendor/bundles/Mopa/BootstrapBundle
git submodule init
git submodule update
```


### Including Bootstrap as own vendor dependency in deps:

To have bootstrap installed by the vendors script of symfony use the following in your deps file:

```
[TwitterBootstrap2]
    git=git://github.com/twitter/bootstrap.git
    target=/twitter/bootstrap/v2/
    version=v2.0.0
```

### Including Bootstrap automatically by composer:

To use MopaBootstrapBundle with composer you can rely on the recommended packages which show different bootstrap2 versions to install


### Including Bootstrap manually

To use bootstrap without less just download the zipped distribution

 http://twitter.github.com/bootstrap/assets/bootstrap.zip
 
 and unpack it e.g.
 
 in app/Resources/public/

