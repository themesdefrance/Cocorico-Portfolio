<?php

if(!function_exists('coco_portfolio_add_project_metaboxes')){
	function coco_portfolio_add_project_metaboxes(){
		add_meta_box(
			'project_meta',
			__('Project details', 'cocoportfolio'),
			'coco_portfolio_project_callback',
			 'portfolio',
			 'normal',
			 'high'
		 );

	}
}
add_action('admin_init', 'coco_portfolio_add_project_metaboxes');
	
if(!function_exists('coco_portfolio_project_callback')){
	function coco_portfolio_project_callback( $post ) {	

		$form = new Cocorico(COCO_PORTFOLIO_COCORICO_PREFIX, false);
		$form->startForm();
		
		$form->setting(array('type' 		=> 'text',
							 'name' 		=> 'client',
							 'label'		=>__("Client", 'cocoportfolio'),
							 'description'	=>__("Enter the client name", 'cocoportfolio')));
							 
		$form->setting(array('type' 		=> 'url',
							 'name' 		=> 'website',
							 'label'		=>__("URL", 'cocoportfolio'),
							 'description'	=>__("Enter the project URL", 'cocoportfolio')));
		
		$form->endForm();
		$form->render();
	}
}