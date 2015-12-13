<?php
#Activation du support pour les images à la une et définition des grosseurs voulues
add_image_size("banniere", 1920, 400, true);
add_image_size("image_a_la_une", 520, 360, true);
add_image_size("carrousel", 1920, 700, true);
add_image_size("commanditaire", 240, 150, false);

#Retina
#add_image_size("banniere@2x", 3840, 800, true);
#add_image_size("image_a_la_une@2x", 1040, 720, true);
#add_image_size("carrousel@2x", 3840, 1400, true);
#add_image_size("commanditaire@2x", 480, 300, false);

#Enlever les formats d'image par défaut
function EnleverFormatDefaut($F)
{
	unset($F["thumbnail"]);
	unset($F["large"]);
	
	return $F;
}

add_filter("intermediate_image_sizes_advanced", "EnleverFormatDefaut");

#Enregistrement de l'emplacement de menu
function AjouterMenu()
{
	register_nav_menus(
		array(
		"menu-principal" => __("Menu principal", "cocathedrale"),
		"pied-de-page" => "Pied de page"
	));
}

add_action("init", "AjouterMenu");

#Enlève les classes et les id sur le items de menu
function EnleverClassId($Args)
{
	return is_array($Args) ? array() : "";
}

add_filter("nav_menu_css_class", "EnleverClassId");
add_filter("nav_menu_item_id", "EnleverClassId");

#Ajout des feuilles de style et du js
function AjouterCssJs()
{
	#index.js
	wp_register_script("mon_script",
		get_template_directory_uri() . "/js/index.js",
		array('jquery'));
	wp_enqueue_script("mon_script");
	
	#Autoriser le Ajax
	#wp_localize_script("mon_script", "ajaxurl", admin_url("admin-ajax.php"));
}

add_action('wp_enqueue_scripts', 'AjouterCssJs');

#Nombre d'articles sur une page
/*function MaxArticles($query)
{
	if (is_single() || is_home())
	{
		$query->set("posts_per_page", "3");
	}
}*/

#add_action("pre_get_posts", "MaxArticles");

#Personnaliser l'éditeur de texte WP
function PersonnaliserÉditeur($in)
{
	$in["remove_linebreaks"] = false;
	$in["convert_newlines_to_brs"] = false;
	$in["wpautop"] = false; #Permet de préserver les sauts de ligne
	$in["block_formats"] = "Paragraphe=p; Titre=h2";
	$in["toolbar1"] = "formatselect, bold, italic, bullist, link, unlink, spellchecker, wp_fullscreen, pastetext, removeformat, charmap, undo, redo, wp_help";
	$in["toolbar2"] = "";
	
	return $in;
}

add_filter("tiny_mce_before_init", "PersonnaliserÉditeur");

#Enlever l'éditeur HTML de l'éditeur de texte WP
function EnleverQuickTags($Param)
{
	$Param["quicktags"] = false;
	return $Param;
}

add_filter("wp_editor_settings", "EnleverQuickTags");

#Limiter l'utilisation d'ACF à l'administrateur
/*function CacherACF($W)
{
	$Utilisateur = wp_get_current_user()->user_login;
	
	if ($Utilisateur != "cocadminthedrale")
	{
		remove_menu_page("edit.php?post_type=acf");
		remove_menu_page("edit.php?post_type=acf-field-group");
	}
}*/

#add_action("admin_menu", "CacherACF");

#Permet de restreindre l'accès aux plugin ACF
/*function RestreindreACF()
{
	$Utilisateur = wp_get_current_user()->user_login;
	$Page = get_current_screen();
	
	#Si on tente d'éditer les champs ACF et qu'on est pas administrateur
	if($Utilisateur !== "cocadminthedrale")
	{
		if ($Page->id == "acf-field-group" || $Page->id == "edit-acf-field-group")
		{
			#Rediriger la personne vers l'admin
			header("Location: " . get_settings("siteurl") . "/wp-admin/index.php");
		}
	}
}*/

#add_action("current_screen", "RestreindreACF");

#Personnaliser l'éditeur de texte WP pour ACf
/*function EditeurAcf($Editeur)
{
	#Créer un nouveau mode
	$Editeur["Résumé"] = array();
	
	#Ajouter une rangée dans le mode
	$Editeur["Résumé"][1] = array("bold, italic, link, unlink, spellchecker, wp_fullscreen, pastetext, removeformat, charmap, undo, redo, wp_help");
	
	#Enlever les autres modes
	unset($Editeur["Full"]);
	unset($Editeur["Basic"]);
	
	return $Editeur;
}*/

#add_filter("acf/fields/wysiwyg/toolbars", "EditeurAcf");

#Personnaliser l'éditeur de média WP
function EditeurMedia()
{
	$Types = array("jpg|jpeg" => "image/jpeg", "png" => "image/png", "svg" => "image/svg+xml", "pdf" => "application/pdf");
	
	return $Types;
}

add_filter("upload_mimes", "EditeurMedia");

#Régler jQuery is not defined avec Gravity Forms
/*function CDataOpen($Contenu = "")
{
	$Contenu = "document.addEventListener('DOMContentLoaded', function(){";
	
	return $Contenu;
}*/

#add_filter("gform_cdata_open", "CDataOpen");

/*function CDataClose($Contenu = "")
{
	$Contenu = "}, false );";
	
	return $Contenu;
}*/

#add_filter("gform_cdata_close", "CDataClose");

#Gravity Form défile la page lors de la validation du formulaire
#add_filter("gform_confirmation_anchor", "__return_true");

#Enlever placeholder.js pour Gravity Forms
/*function EnleverPlaceholder()
{
	if (! is_admin())
	{
		wp_deregister_script("gform_placeholder");
	}
}*/

#add_action("wp_print_scripts", "EnleverPlaceholder", 100);

#Change le tabIndex des formulaires
/*function ChangerTabIndex($Tab)
{
	return 100;
}*/

#add_filter("gform_tabindex", "ChangerTabIndex");

#Ajoute l'autocomplete pour Gravity Forms
/*function AutocompleteForms($Tag, $Form)
{
	if (!is_admin())
	{
		$Tag = str_replace(">", " autocomplete='on'>", $Tag);
	}
	
	return $Tag;
}*/

#add_filter("gform_form_tag", "AutocompleteForms", 10, 2);

#Ajouter les champs ACf pour WP Seo
function AjouterAcfSeo($Contenu, $Post)
{	
	$Titre = get_the_title();
	
	#S'assurer que le résumé existe
	$Resume = "";
	
	if (get_field("resume")) $Resume = get_field("resume");
	
	#S'assurer que l'image existe
	$Image = "";
	
	if (get_field("image_a_la_une"))
	{
		$Image = "<img src='" . get_field("image_a_la_une")["url"] . "' alt='" . get_field("image_a_la_une")["alt"] . "' />";
	}
	
	return $Titre . $Resume . $Image . $Contenu;
}

add_filter("wpseo_pre_analysis_post_content", "AjouterAcfSeo", 10, 2);

#Activation du fil d'arianne pour Yoast SEO
#add_theme_support("yoast-seo-breadcrumbs");

#S'assurer que les résumés on au moins 300 caractères
/*function ValidationTailleResume($Valide, $Valeur, $Champ, $Input)
{
	#Erreur si le champ est déjà invalide
	if (!$Valide) return $Valide;
	
	$Longueur = strlen($Valeur);
	
	if ($Longueur < 300 || $Longueur > 450)
	{
		$Valide = "Le résumé doit contenir entre 300 et 450 caractères";
	}
	
	return $Valide;
}*/

#add_filter("acf/validate_value/name=resume", "ValidationTailleResume", 10, 4);

#Permet de vérifier la présence du Alt sur les images
function ValiderImage($Valide, $Id, $Champ, $Input)
{
	if (!$Valide) return $Valide;
	
	#Aller chercher le texte alternatif sur les images
	$Alt = get_post_meta($Id, "_wp_attachment_image_alt", true);
	
	if (empty($Alt))
	{
		$Valide = "Le texte alternatif de l'image doit contenir la description de l'image";
	}
	
	return $Valide;
}

add_filter("acf/validate_value/type=image", "ValiderImage", 10, 4);

#Enlever le support pour les éditeurs de blog
remove_action("wp_head", "wlwmanifest_link");
remove_action("wp_head", "rsd_link");

#Permet de retourner un srcset @2x s'il y a lieu
#	$Id:			ID du post ou de la page
#	$Champ:			Champ à vérifier
#	$Image:			Taille de l'image à vérifier
#	$SousChamp:		$SousChamp ACF, s'il y a lieu
/*function ImageHD($Id, $Champ, $Image, $SousChamp = "")
{
	global $_wp_additional_image_sizes;
	
	$Infos = $_wp_additional_image_sizes[$Image];
	
	#Si la taille de l'image existe
	if (isset($Infos))
	{
		#Obtenir sa largeur et sa hauteur
		$L = $Infos["width"];
		$H = $Infos["height"];
		
		#Aller chercher le champ d'image
		$Champ = get_field($Champ, $Id);
		
		if (!empty($SousChamp))
		{
			$Val = [];
			
			foreach ($Champ as $C)
			{
				$SC = $C[$SousChamp];
				
				$Val[] = ComparerTailles($L, $H, $SC, $Image);
			}
			
			return $Val;
		}
		else
		{
			return ComparerTailles($L, $H, $Champ, $Image);
		}
	}
	
	return "";
}*/

#Permet de savoir si une image haute densité existe
#Est utilisé avec ImageHD
#	$L:	Largeur de l'image
#	$H: Hauteur de l'image
#	$Champ: Le champ à vérifier
#	$Image: La taille de l'image haute densitée
/*function ComparerTailles($L, $H, $Champ, $Image)
{
	#Aller chercher les dimensions du champ
	$L2 = $Champ["sizes"][$Image . "-width"];
	$H2 = $Champ["sizes"][$Image . "-height"];
	
	#Si les dimensions correspondent
	if ($L == $L2 && $H == $H2)
	{
		return "srcset='" . $Champ["sizes"][$Image] . " 2x'";
	}
	
	return "";
}*/

#Enlever les emojis
function EnleverEmojis()
{
	remove_action("admin_print_styles", "print_emoji_styles");
	remove_action("wp_head", "print_emoji_detection_script", 7);
	remove_action("admin_print_scripts", "print_emoji_detection_script");
	remove_action("wp_print_styles", "print_emoji_styles");
	remove_filter("wp_mail", "wp_staticize_emoji_for_email");
	remove_filter("the_content_feed", "wp_staticize_emoji");
	remove_filter("comment_text_rss", "wp_staticize_emoji");
}

add_action("init", "EnleverEmojis");

#Empêcher la supression de l'admin
add_action(
	"load-users.php",
	function()
	{
		if (isset($_GET["action"]) && $_GET["action"] === "delete")
		{
			if (isset($_GET["user"]))
			{
				$User = get_userdata($_GET["user"]);
				
				if ($User->user_login == "OlivierBrochu")
				{
					wp_die("Cet utilisateur ne peut pas être supprimé");
				}
			}
		}
	}
);

add_action(
	"delete_user",
	function($ID)
	{
		$User = get_userdata($ID);
		
		if ($User->user_login == "OlivierBrochu")
		{
			wp_die("Cet utilisateur ne peut pas être supprimé");
		}
	}
);

#Ajout de l'AJAX
class Recherche
{
	function Recherche()
	{
		add_action("wp_ajax_Recherche", array($this, "Rechercher"));
		add_action("wp_ajax_nopriv_Recherche", array($this, "Rechercher"));
	}
	
	function Rechercher()
	{
		$Mot = $_REQUEST["mot-cle"];
		$Nombre = isset($_REQUEST["articles"]) ? $_REQUEST["articles"]:3;
		
		$Requete = new WP_Query(array("s" => $Mot, "posts_per_page" => intval($Nombre), post_status => "publish", "post__not_in" => array(230, 180)));
		
		echo "<div class='Wrapper'>";
		
		if ($Requete->have_posts())
		{
			while ($Requete->have_posts())
			{
				$Requete->the_post();
				
				?>
					<a href="<?php the_permalink(); ?>">
						<article>
							<img src="<?php echo get_field("image_a_la_une")["sizes"]["image_a_la_une"]; ?>" <?php echo ImageHD(get_the_id(), "image_a_la_une", "image_a_la_une@2x"); ?> alt="<?php echo get_field("image_a_la_une")["alt"]; ?>" />
							<div></div>
							<div>
								<h1><?php the_title(); ?></h1>
								<p><?php echo strip_tags(get_field("resume")); ?></p>
								<span>Lire la suite »</span>
							</div>
						</article>
					</a>
				<?php
			}
		}
		else
		{
			echo "<p style='text-align: center;'>Votre recherche ne rapporte aucun résultat</p>";
		}
		
		echo "</div>";
		
		wp_reset_postdata();
		die();
	}
}

$Rch = new Recherche();
	
#Create custom plugin settings menu
#add_action("admin_menu", "AjouterMenuOptions");

/*function AjouterMenuOptions()
{
	#Ajouter un menu
	add_options_page("Options", "Options", "administrator", __FILE__, "AfficherOptions");

	#Enregistrer les options
	add_action("admin_init", "EnregistrerOptions");
}

function EnregistrerOptions()
{
	#Enregistrer les options
	register_setting("infos_supplementaires", "logo_url");
	register_setting("infos_supplementaires", "don_desc");
	register_setting("infos_supplementaires", "don_url");
}

function AfficherOptions()
{
	?>
		<div class="wrap">
			<h2>Informations supplémentaires</h2>
			
			<form method="post" action="options.php">
				<?php
					settings_fields("infos_supplementaires");
					do_settings_sections("infos_supplementaires");
				?>
				
				<table class="form-table">
					<tr valign="top">
						<th scope="row">Adresse du logo (URL)</th>
						<td><input type="text" name="logo_url" value="<?php echo esc_attr(get_option("logo_url")); ?>" class="regular-text" /></td>
					</tr>
					
					<tr valign="top">
						<th scope="row">Description de la bannière de don</th>
						<td><input type="text" name="don_desc" value="<?php echo esc_attr(get_option("don_desc")); ?>" class="regular-text" maxlength="60" required /></td>
					</tr>
					
					<tr valign="top">
						<th scope="row">Adresse du bouton de don (URL)</th>
						<td><input type="text" name="don_url" value="<?php echo esc_attr(get_option("don_url")); ?>" class="regular-text" required /></td>
					</tr>		
				</table>
				
				<?php submit_button(); ?>
			</form>
		</div>
	<?php
}*/
// Register Custom Post Type
function etudiants() {

	$labels = array(
		'name'                  => _x( 'Étudiants', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'Étudiant', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'Etudiants', 'text_domain' ),
		'name_admin_bar'        => __( 'Etudiants', 'text_domain' ),
		'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
		'all_items'             => __( 'All Items', 'text_domain' ),
		'add_new_item'          => __( 'Add New Item', 'text_domain' ),
		'add_new'               => __( 'Add New', 'text_domain' ),
		'new_item'              => __( 'New Item', 'text_domain' ),
		'edit_item'             => __( 'Edit Item', 'text_domain' ),
		'update_item'           => __( 'Update Item', 'text_domain' ),
		'view_item'             => __( 'View Item', 'text_domain' ),
		'search_items'          => __( 'Search Item', 'text_domain' ),
		'not_found'             => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
		'items_list'            => __( 'Items list', 'text_domain' ),
		'items_list_navigation' => __( 'Items list navigation', 'text_domain' ),
		'filter_items_list'     => __( 'Filter items list', 'text_domain' ),
	);
	$args = array(
		'label'                 => __( 'Étudiant', 'text_domain' ),
		'description'           => __( 'Liste des etudiants de Dectim', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions', 'custom-fields', 'page-attributes', 'post-formats', ),
		'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-universal-access-alt',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,		
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'etudiants', $args );

}
add_action( 'init', 'etudiants', 0 );
// Register Custom Post Type
function enseignants() {

	$labels = array(
		'name'                  => _x( 'Enseignants', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'Enseignant', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'Enseignants', 'text_domain' ),
		'name_admin_bar'        => __( 'Enseignants', 'text_domain' ),
		'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
		'all_items'             => __( 'All Items', 'text_domain' ),
		'add_new_item'          => __( 'Add New Item', 'text_domain' ),
		'add_new'               => __( 'Add New', 'text_domain' ),
		'new_item'              => __( 'New Item', 'text_domain' ),
		'edit_item'             => __( 'Edit Item', 'text_domain' ),
		'update_item'           => __( 'Update Item', 'text_domain' ),
		'view_item'             => __( 'View Item', 'text_domain' ),
		'search_items'          => __( 'Search Item', 'text_domain' ),
		'not_found'             => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
		'items_list'            => __( 'Items list', 'text_domain' ),
		'items_list_navigation' => __( 'Items list navigation', 'text_domain' ),
		'filter_items_list'     => __( 'Filter items list', 'text_domain' ),
	);
	$args = array(
		'label'                 => __( 'Enseignant', 'text_domain' ),
		'description'           => __( 'Liste des enseignants de Dectim', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions', 'custom-fields', 'page-attributes', 'post-formats', ),
		'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-universal-access',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,		
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'enseignants', $args );

}
add_action( 'init', 'enseignants', 0 );