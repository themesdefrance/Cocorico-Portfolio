<?php

////////////////////////////////////
// Cocorico Framework
////////////////////////////////////

$form = new Cocorico(COCO_PORTFOLIO_COCORICO_PREFIX);

$form->startWrapper('titre');
$form->component('raw', __('Cocorico Portfolio Settings', 'cocoportfolio'));
$form->endWrapper('titre');

$form->groupHeader(array('general'=>__('General', 'cocoportfolio')));

$form->startWrapper('tab', 'general');

$form->startForm();

$form->component('raw', 'Options du plugin');

/*$form->setting(
	array(
		'type' => 'text',
		'name' => 'archive_slug',
		'label' => __('Archive slug', 'cocoportfolio'),
		'description' => __('This settings lets you change the projects archive URL slug (default is "portfolio").', 'cocoportfolio') . __('<br><small>(please visit the Permalinks Settings page after changing this setting)</small>', 'cocoportfolio'),
		'options' => array(
			'default' => 'portfolio'
		)
	)
);

$form->setting(
	array(
		'type' => 'text',
		'name' => 'project_slug',
		'label' => __('Single project slug', 'cocoportfolio'),
		'description' => __('This settings lets you change a single project URL slug (default is "project").', 'cocoportfolio') . __('<br><small>(please visit the Permalinks Settings page after changing this setting)</small>', 'cocoportfolio'),
		'options' => array(
			'default' => 'project'
		)
	)
);

$form->setting(
	array(
		'type' => 'text',
		'name' => 'project_category_slug',
		'label' => __('Project category slug', 'cocoportfolio'),
		'description' => __('This settings lets you change the projects categories URL slug (default is "project-category").', 'cocoportfolio') . __('<br><small>(please visit the Permalinks Settings page after changing this setting)</small>', 'cocoportfolio'),
		'options' => array(
			'default' => 'project-category'
		)
	)
);*/

$form->endForm();

$form->endWrapper('tab');


$form->component('submit', 'submit', array('value'=>__('Save Changes', 'cocoportfolio')));

$form->render();

?>

<div style="margin-top:20px;">

<?php _e('Cocorico Portfolio is brought to you by','cocoportfolio'); ?> <a href="https://www.themesdefrance.fr/?utm_source=plugin&utm_medium=link&utm_campaign=cocoriportfolio" target="_blank">Themes de France</a> - <?php _e('If you found this plugin useful','cocoportfolio'); ?>, <a href="http://wordpress.org/support/view/plugin-reviews/cocorico-portfolio" target="_blank"><?php _e('give it 5 &#9733; on WordPress.org','cocoportfolio'); ?></a>

</div>



