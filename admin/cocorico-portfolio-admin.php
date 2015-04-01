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

$form->component('raw', 'Options du plugin à définir voire à supprimer');

$form->endForm();

$form->endWrapper('tab');


$form->component('submit', 'submit', array('value'=>__('Save Changes', 'cocoportfolio')));

$form->render();

?>

<div style="margin-top:20px;">

<?php _e('Cocorico Portfolio is brought to you by','cocoportfolio'); ?> <a href="https://www.themesdefrance.fr/?utm_source=plugin&utm_medium=link&utm_campaign=cocoriportfolio" target="_blank">Themes de France</a> - <?php _e('If you found this plugin useful','cocoportfolio'); ?>, <a href="http://wordpress.org/support/view/plugin-reviews/cocorico-portfolio" target="_blank"><?php _e('give it 5 &#9733; on WordPress.org','cocoportfolio'); ?></a>

</div>



