ScabrosFW

a PHP micro-framework.

Features:
-supports templates
-supports translations
-class autoloading
-error detection and handling
-simple to learn application organization
-simple SQL abstraction layer
-simple data validation
-simple response messages convention
-decoupled components

The Idea:

The main ideas behind this frawmework are:
-evade fat MVC frameworks, with complex routing, slow models, etc.
-simplify to allow rapid development, focused on what should be done

We have no "Models". We have no "Controllers". We encourage the developer 
to organize his work in a collection of "micro-controllers" to manage the 
application FLOW and a collection of classes to solve the application LOGIC.
The "templating" is handled with three simple classes: Layout for screen 
organization and layout; Tpl to parse native php templates with custom data;
and T to simplify some tedious tasks (show and translate tpl DATA).

By Example:

So, if you want a login page, you create a "micro-controller" in the desired
folder, anywhere. This login page should check if there is any data submitted
and then call the login METHOD of the corresponding class. In THAT login METHOD
you can validate the data, connect to database, escape the data, execute the 
appropiate SQL statement, check the returned data, and finally, if everything
is OK, return a Response with the success flag on it. In this case you could 
also write a "$_SESSION" var, to initialize the user session. In the case of an
error, in the data validation step or in any other, the login METHOD should 
return a Response with the success flag property set to FALSE. The msg property
of the response should contain info about the failure (messages about data 
validation, user not found, etc). Then, back in the micro-controller, the 
developer must decide how to handle the action response. If it was successfull,
maybe can redirect to a new page with the standard redirect function. If it had
an error, maybe he should re-populate the form with the data (or not) and show 
the error msg with the appropiate function.
As you see, the flow of the application is in total control of the developer,
but he is encouraged to follow some key concepts.


Conventions:
-All of your custom classes should be in the classes folder of the framework
-All your micro-controllers should load the framework requiring the file 
"load.php" in the first line
-All your templates should be in a directory called "tpls" in the same folder
of the micro-controller, or, if it's a common tpl used widely in the app, it
should be in the tpls directory in the system root.
-all the code you want to run in some pages, but not all (like session 
validation), should be in another file named "init.php"
-All of your custom classes should return an object response with succes, msg
and data properties
-All your third party libs should be in lib/ folder
