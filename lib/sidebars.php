<?php
register_sidebar(array(
	'name' => 'Sidebar Widgets',
	'id'   => 'sidebar-widgets',
	'description'   => 'These are widgets for the sidebar.',
	'before_widget' => '<div id="%1$s" class="widget %2$s clearfix">',
	'after_widget'  => '</div>',
	'before_title'  => '<h3>',
	'after_title'   => '</h3>'
));
