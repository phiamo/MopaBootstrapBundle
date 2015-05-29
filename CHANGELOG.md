CHANGELOG for master
====================

This changelog references the relevant changes (api changes) done
in master branch.
    
To get the diff for a specific change, go to https://github.com/phiamo/MopaBootstrapBundle/commit/XXX where XXX is the change hash

 * dc4fd12: [BC Break] Removed inline completely 
 * add75e9: Renamed config mopa_bootstrap.navbar to mopa_bootstrap.menu
 * a4b78d5: Added Version Detection for BS2 or BS3
 * 5f1200f: Changed the widget_addon form parameter to use type (prepend/append) instead of append (true/false)
 * 6d4f685: Using label_attr instead of attr value to define inline button classes @see https://github.com/phiamo/MopaBootstrapSandboxBundle/commit/e808d2b596675f2969c6e42b835761bf00ea575c
 * 004df07: Removed js links in templates provided to prevent assetic errors, you MUST define which js files to include in your project!