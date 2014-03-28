curlybraces.php
===============

_Look ma, a templating engine!_

Since static site generators are all the rage,
I started looking into setting up Jekyll. But
then I got lazy about having to set up Ruby,
etc., so I wrote this, inspired by Brace Tags.
Enjoy.

(Caching is left as an exercise to the reader.)

Templates
---------

Put your files in source/templates (or edit
the TEMPLATE_DIR constant).

To include a file, write

	{% include path/to/file.name %}

To inject a variable, write

	{% variable %}

Example
-------

Base template:

	<html>
		<head><title>{% title %}</title></head>
		<body>{% content %}</body>
	</html>

Page template:

	<p>Hi, {% name %}!</p>

 PHP code:

	require('path/to/curlybraces.php');
	echo CurlyBraces::Compile(
		'path/to/base.template',
		'path/to/page.template',
		array(
			'title' => 'Sweet Demo',
			'name' => 'Takahashi'
		)
	);

References
----------

1. tags.brace.io