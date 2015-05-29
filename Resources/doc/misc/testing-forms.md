Testing MopaBootstrapBundle Forms
==================================================

Since MopaBootstrapBundle uses Symfony Form extensions you can test them as usual Symfony Forms. 
The way of testing them is clearly [described](http://symfony.com/doc/current/cookbook/form/unit_testing.html) in a Cookbook.
The only difference between testing pure Symfony forms and MopaBootstrap Forms is the fact that you need to use `Mopa\Bundle\BootstrapBundle\Tests\Form\TypeTestCase` instead of `Symfony\Component\Form\Test\TypeTestCase` 
You can see an [example](https://github.com/phiamo/MopaBootstrapSandboxBundle/blob/master/Tests/Form/Type/ExampleFormsTypeTest.php) in MopaBootstrapSandboxBundle
