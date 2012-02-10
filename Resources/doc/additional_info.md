
if your are e.g. using cssembed, you might notice problems when embedding bootrap via less:

[RuntimeException]                                                                                                                                   
  [ERROR] /path/to/your/bundle/Resources/public/less/../img/glyphicons-halflings.png (No such file or directory)  


this is due to cssembed and bootstrap not working so nicely with relative paths.

The most easies ways is to copy the glyphicons-halflings.png from

your/path/to/bootstrap/img/glyphicons-halflings.png to /path/to/your/bundle/Resources/public/img/

so cssembed finds the file in the corresponding position
