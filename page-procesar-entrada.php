<?php 

/*
Template Name: Página publicaciones entradas desde el front

*/
/* Pueden aplicar esta plantilla de página a cualquier página, y los usuarios podrán publicar en tu blog */
/* Las entradas se publicarán como 'pending', es decir, deberán ser aprobadas */


/***************************************************************/
/** Este es el código de validación y el que añade la entrada **/
/***************************************************************/
$postTitleError = '';

if(isset($_POST['submitted']) && isset($_POST['post_nonce_field']) && wp_verify_nonce($_POST['post_nonce_field'], 'post_nonce')) {

	if(trim($_POST['postTitle']) === '') {
		$postTitleError = 'Por favor, introduce un título.';
		$hasError = true;
	} else {
		$postTitle = trim($_POST['postTitle']);
	}

	$cat = array( $_POST['cat'] );
	$post_information = array(
		'post_title' => esc_attr(strip_tags($_POST['postTitle'])),
		'post_content' => $_POST['postcontent'],
		'post_category' => $cat,
		'tags_input'    => $_POST['postTags'],
		'post_type' => 'post',
		'post_status' => 'pending'
	);

	$post_id = wp_insert_post($post_information);

	if($post_id)
	{
		wp_redirect(home_url());
		exit;
	}

}

/******************************************************************/
/** Finalizada el código de validación y el que añade la entrada **/
/******************************************************************/

/******************************************************************/
/*** comienza el código del forumario, deberás cambiar ciertas ****/
/** cosas para que concuerden con tu plantilla ********************/
/******************************************************************/

?>

<!-- Aquí empiza la estrucura y diseño de tu theme, debes sustituirlo por la de tu theme --->
<?php get_header(); ?>

<div id="primary" class="site-content">
		<div id="content" role="main">

<!-- Comienza el formulario de envio en si -->

			<div id="postbox">
					<form action="" id="primaryPostForm" method="POST">
							<fieldset>
									<label for="postTitle"><?php _e('Título:', 'framework') ?></label>
									<input type="text" name="postTitle" id="postTitle" value="<?php if(isset($_POST['postTitle'])) echo $_POST['postTitle'];?>" class="required" />
							</fieldset>
							<?php if($postTitleError != '') { ?>
								<span class="error"><?php echo $postTitleError; ?></span>
								<div class="clearfix"></div>
							<?php } ?>
							
							
									<label for="postcontent2"><?php _e('Contenido:', 'framework') ?></label>
									<?php $postcontent = ''; wp_editor( $postcontent, 'postcontent', $settings = array('wpautop'); //Añadimos el editor de WordPress en el front. En estos momentos (WordPress 3.5.x), parece que hay un bug que solo los Administradores pueden subir imagenes?>
							
							<fieldset>
									<label for="postTitle">Selecciona un categoría</label>
									<?php wp_dropdown_categories( 'show_option_none=Category&hide_empty=0&tab_index=4&taxonomy=category' ); //Hacemos que se muestren todas las categorías, aunque no tengan ninguna entrada asociada. Crea todas las categorias que necesites para que los usuarios puedan asociar la entrada que publiquen a una categoría. El que se muestren , se consigue mendiante hide_empty=0 ?>
							</fieldset>
							<fieldset>
									<label for="postTags">Etiquetas (Debes separarlas por comas)</label>
									<input type="text" value="" tabindex="5" size="16" name="postTags" id="postTags" />
							</fieldset>
							<fieldset>
									<?php wp_nonce_field('post_nonce', 'post_nonce_field'); ?>
									<input type="hidden" name="submitted" id="submitted" value="true" />
									<button type="submit"><?php _e('Añadir entrada', 'framework') ?></button>
							</fieldset>
					</form>
			</div> <!-- Finaliza el formulario de envio de la entrada -->
<!-- a partir de aquí, debes modificarlo según la estructura de tu theme para que se ajuste a tu diseño -->
		</div><!-- #content -->
</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
