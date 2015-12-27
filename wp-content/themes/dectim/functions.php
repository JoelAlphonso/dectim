<?php
#Activation du support pour les images à la une et définition des grosseurs voulues
add_image_size("page_accueil", 700, 467, true);
add_image_size("grille", 450, 450, true);

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
		"menu-principal" => __("Menu principal", "cocathedrale")
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
	wp_localize_script("mon_script", "ajaxurl", admin_url("admin-ajax.php"));
}

add_action('wp_enqueue_scripts', 'AjouterCssJs');

#Réécriture des titres des pages
function getPageTitle()
{
	#Le titre
	$leTitre = "";
	
	#Remplir le before (titre des pages)
	$before = "";
	
	if (is_page() || is_single())
	{
		$leTitre .= get_the_title() . " - ";
	}
	
	#Remplir la section avec le nom et le slogan
	$leTitre .= get_bloginfo("name");
	$desc = get_bloginfo("description");
	
	if (!empty($desc)) $leTitre .= " | " . $desc;
	
	echo $leTitre;
}

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

#Personnaliser l'éditeur de média WP
function EditeurMedia()
{
	$Types = array("jpg|jpeg" => "image/jpeg", "png" => "image/png", "svg" => "image/svg+xml", "pdf" => "application/pdf");
	
	return $Types;
}

add_filter("upload_mimes", "EditeurMedia");

#S'assurer que les résumés on au moins 300 caractères
function ValidationAnneGrilleFinissants($Valide, $Valeur, $Champ, $Input)
{
	$ValNum = intval($Valeur);
	
	if ($ValNum >= 2016 || $ValNum == 0)
	{
		$Valide = true;
	}
	else
	{
		$Valide = "Entrez une valeur supérieure à 2016. La valeur zéro est acceptée";
	}
	
	return $Valide;
}

add_filter("acf/validate_value/name=annee", "ValidationAnneGrilleFinissants", 10, 4);

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

#Ajout de l'AJAX pour la grille d'étudiants
class RechercheEtudiants
{
	function RechercheEtudiants()
	{
		add_action("wp_ajax_RechercheEtudiants", array($this, "RechercherEtudiants"));
		add_action("wp_ajax_nopriv_RechercheEtudiants", array($this, "RechercherEtudiants"));
	}
	
	function RechercherEtudiants()
	{	
		$mots = $_REQUEST["mot-cle"];
		$annee = isset($_REQUEST["annee"]) ? $_REQUEST["annee"]:"2016";
		
		getEtudiants($annee, $mots);
		
		#echo "<p style='text-align: center;'>Votre recherche ne rapporte aucun résultat</p>";
		
		wp_reset_postdata();
		die();
	}
}

$Rch = new RechercheEtudiants();

function getEtudiants($annee, $recherche="")
{	
	$args = array(
		"post_type" => "etudiant_post_type",
		"nopaging" => true,
		"orderby" => "name",
		"order" => "ASC",
		"meta_query" => array(
			array(
				"key" => "annee_graduation",
				"value" => $annee,
				"type"=> "NUMERIC",
				"compare" => "LIKE"
			)
		)
	);
	
	#Commencer une query WP
	$query = new WP_Query($args);

	#Aller chercher tous les étudiants
	if ($query->have_posts())
	{
		$i = 0;
		
		while ($query->have_posts())
		{
			$query->the_post();
			
			$nom = explode(" ", get_the_title());
			$prenom = array_shift($nom);
			$url = empty(get_field("url_portfolio")) ? "javascript:void(0)" : get_field("url_portfolio");
			
			#Aller chercher les profils
			$profils = get_the_term_list($post->ID, "profil", "", ",");
			$profils = strip_tags($profils);
			$profils = explode(",", $profils);
			
			#Si on recherche, filtrer les étudiants
			if (!empty($recherche))
			{
				$keep = filterEtudiants($recherche, $prenom, implode(" ", $nom), $profils);
				
				if (!$keep) continue;
			}
			?>
				<article tabindex="<?php echo $i; ?>">
					<div>
						<span></span>
						<p><?php echo $prenom; ?><span><?php echo implode($nom); ?></span></p>
						
						<?php if (count($profils) > 1): ?>
							<ul>
								<?php for ($j = 0; $j < min(count($profils), 3); $j++): ?>
									<li><?php echo $profils[$j]; ?></li>
								<?php endfor; ?>
							</ul>
						<?php endif; ?>
						
						<a href="<?php echo $url; ?>" target="_blank">Portfolio</a>
					</div>

					<p><?php echo $prenom; ?><span><?php echo implode($nom); ?></span></p>
					<img src="<?php echo get_field("photo_etudiant")["sizes"]["grille"]; ?>" alt="<?php the_title(); ?>" />
				</article>
			<?php
				$i++;
		}
	}

	#Ajouter des fillers
	for ($i = 0; $i < 3; $i++):
	?>
		<article class="filler">
		</article>
	<?php
	endfor;

	wp_reset_postdata();
}

#Permet de filtrer les étudiants pour la recherche
function filterEtudiants($searchParam, $prenom = "", $nom = "", $profils = array())
{
	#Tout mettre en minuscules et enlever les accents
	$searchParam = enleverAccents(strtolower($searchParam));
	$prenom = enleverAccents(strtolower($prenom));
	$nom = enleverAccents(strtolower($nom));
	$profils = array_map("enleverAccents", array_map("strtolower", $profils));
	
	#Assembler les mots clés
	$motscle = implode(" ", array($prenom, $nom, implode(" ", $profils)));
	
	#Vérifier si on garde le post
	$keep = false;
	$index = strpos($motscle, $searchParam);
	
	if ($index === false)
	{
		
	}
	else
	{
		$keep = true;
	}
	
	return $keep;
}

function enleverAccents($chaine, $charset = "utf-8")
{
    $chaine = htmlentities($chaine, ENT_NOQUOTES, $charset);
    
    $chaine = preg_replace('#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $chaine);
    $chaine = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $chaine); #Pour les ligatures e.g. '&oelig;'
    $chaine = preg_replace('#&[^;]+;#', '', $chaine); #Supprime les autres caractères
    
    return $chaine;
}

/**************************
	Professeurs
**************************/
function getProfesseurs()
{
	$args = array(
		"post_type" => "enseignant_post_type",
		"nopaging" => true,
		"orderby" => "name",
		"order" => "ASC"
	);
	
	#Commencer une query WP
	$query = new WP_Query($args);

	#Aller chercher tous les étudiants
	if ($query->have_posts())
	{
		while ($query->have_posts())
		{
			$query->the_post();
			
			#Aller chercher le nom
			$nom = explode(" ", get_the_title());
			$prenom = array_shift($nom);
			?>
				<article>
					<p><?php echo $prenom; ?><span><?php echo implode($nom); ?></span></p>
					<img src="<?php echo get_field("photo_enseignant")["sizes"]["grille"]; ?>" alt="<?php the_title(); ?>" />
				</article>
			<?php
		}
	}

	#Ajouter des fillers
	for ($i = 0; $i < 3; $i++):
	?>
		<article class="filler">
		</article>
	<?php
	endfor;

	wp_reset_postdata();
}

// Register Custom Taxonomy
function profil() {

	$labels = array(
		'name'                       => _x( 'Profils', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Profil', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Profils', 'text_domain' ),
		'all_items'                  => __( 'Tous les profils', 'text_domain' ),
		'parent_item'                => __( 'Profil parent', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent:', 'text_domain' ),
		'new_item_name'              => __( 'Nouveau profil', 'text_domain' ),
		'add_new_item'               => __( 'Ajouter un profil', 'text_domain' ),
		'edit_item'                  => __( 'Modifier un profil', 'text_domain' ),
		'update_item'                => __( 'Mettre à jour le profil', 'text_domain' ),
		'view_item'                  => __( 'Visionner le profil', 'text_domain' ),
		'separate_items_with_commas' => __( 'Séparer avec des virgules', 'text_domain' ),
		'add_or_remove_items'        => __( 'Ajouter ou supprimer un profil', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choisir parmis les plus utilisés', 'text_domain' ),
		'popular_items'              => __( 'Profils populaires', 'text_domain' ),
		'search_items'               => __( 'Rechercher un profil', 'text_domain' ),
		'not_found'                  => __( 'Profil introuvable', 'text_domain' ),
		'no_terms'                   => __( 'Pas de profil', 'text_domain' ),
		'items_list'                 => __( 'Liste des profils', 'text_domain' ),
		'items_list_navigation'      => __( 'Liste de navigation des profils', 'text_domain' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'profil', array( 'etudiant_post_type', 'enseignant_post_type' ), $args );

}
add_action( 'init', 'profil', 0 );


// Register Custom Post Type
function student_post_type() {

	$labels = array(
		'name'                  => _x( 'Étudiants', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'Étudiant', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'Étudiants', 'text_domain' ),
		'name_admin_bar'        => __( 'Post Type', 'text_domain' ),
		'archives'              => __( 'Archive de l\'étudiant', 'text_domain' ),
		'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
		'all_items'             => __( 'Tous les étudiants', 'text_domain' ),
		'add_new_item'          => __( 'Ajouter un nouvel étudiant', 'text_domain' ),
		'add_new'               => __( 'Ajouter un étudiant', 'text_domain' ),
		'new_item'              => __( 'Nouvel étudiant', 'text_domain' ),
		'edit_item'             => __( 'Modifier la fiche de l\'étudiant', 'text_domain' ),
		'update_item'           => __( 'Mettre a jour la fiche de l\'étudiant', 'text_domain' ),
		'view_item'             => __( 'Visionner la fiche de l\'étudiant', 'text_domain' ),
		'search_items'          => __( 'Rechercher un étudiant', 'text_domain' ),
		'not_found'             => __( 'Impossible de trouver l\'étudiant', 'text_domain' ),
		'not_found_in_trash'    => __( 'Impossible de trouver l\'étudiant dans la corbeil', 'text_domain' ),
		'featured_image'        => __( 'Image en vedette', 'text_domain' ),
		'set_featured_image'    => __( 'Mettre l\'image en vedette', 'text_domain' ),
		'remove_featured_image' => __( 'Retirer l\'image en vedette', 'text_domain' ),
		'use_featured_image'    => __( 'Utiliser comme image en vedette', 'text_domain' ),
		'insert_into_item'      => __( 'Insert into item', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Téléverser dans la fiche', 'text_domain' ),
		'items_list'            => __( 'Liste des étudiants', 'text_domain' ),
		'items_list_navigation' => __( 'Navigation de la liste des etudiants', 'text_domain' ),
		'filter_items_list'     => __( 'Filtrer', 'text_domain' ),
	);
	$rewrite = array(
		'slug'                  => 'post_type',
		'with_front'            => true,
		'pages'                 => false,
		'feeds'                 => true,
	);
	$args = array(
		'label'                 => __( 'Étudiant', 'text_domain' ),
		'description'           => __( 'Etudiants du programme', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => array( ),
		'taxonomies'            => array(),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-groups',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,		
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'rewrite'               => $rewrite,
		'capability_type'       => 'page',
	);
	register_post_type( 'etudiant_post_type', $args );

}
add_action( 'init', 'student_post_type', 0 );


// Register Custom Post Type
function teacher_post_type() {

	$labels = array(
		'name'                  => _x( 'Enseignants', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'Enseignant', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'Enseignants', 'text_domain' ),
		'name_admin_bar'        => __( 'Enseignants', 'text_domain' ),
		'archives'              => __( 'Archive des enseignants', 'text_domain' ),
		'parent_item_colon'     => __( 'Parent de l\'enseignant', 'text_domain' ),
		'all_items'             => __( 'Tous les enseignants', 'text_domain' ),
		'add_new_item'          => __( 'Ajouter un enseignant', 'text_domain' ),
		'add_new'               => __( 'Ajouter un enseignant', 'text_domain' ),
		'new_item'              => __( 'Nouvel enseignant', 'text_domain' ),
		'edit_item'             => __( 'Modifier la fiche de l\'enseignant', 'text_domain' ),
		'update_item'           => __( 'Mettre à jour la fiche de l\'enseignant', 'text_domain' ),
		'view_item'             => __( 'Visionner la fiche de l\'enseignant', 'text_domain' ),
		'search_items'          => __( 'Rechercher un enseignant', 'text_domain' ),
		'not_found'             => __( 'Enseignant introuvable', 'text_domain' ),
		'not_found_in_trash'    => __( 'Enseignant introuvable dans la corbeil', 'text_domain' ),
		'featured_image'        => __( 'Image en vedette', 'text_domain' ),
		'set_featured_image'    => __( 'Mettre l\'image en vedette', 'text_domain' ),
		'remove_featured_image' => __( 'Retirer l\'image en vedette', 'text_domain' ),
		'use_featured_image'    => __( 'Utiliser comme image en vedette', 'text_domain' ),
		'insert_into_item'      => __( 'Insérer dans la fiche de l\'enseignant', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Téléverser dans la fiche de l\'enseignant', 'text_domain' ),
		'items_list'            => __( 'Liste des enseignants', 'text_domain' ),
		'items_list_navigation' => __( 'Navigation de la liste des enseignants', 'text_domain' ),
		'filter_items_list'     => __( 'Filter', 'text_domain' ),
	);
	$rewrite = array(
		'slug'                  => 'enseignants-tim',
		'with_front'            => true,
		'pages'                 => false,
		'feeds'                 => true,
	);
	$args = array(
		'label'                 => __( 'Enseignant', 'text_domain' ),
		'description'           => __( 'Enseignants du programme', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => array( 'title', ),
		'taxonomies'            => array(),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-businessman',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,		
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'rewrite'               => $rewrite,
		'capability_type'       => 'page',
	);
	register_post_type( 'enseignant_post_type', $args );

}
add_action( 'init', 'teacher_post_type', 0 );



 // Register Custom Post Type
function project_post_type() {

	$labels = array(
		'name'                  => _x( 'Projets', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'Projet', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'Projets', 'text_domain' ),
		'name_admin_bar'        => __( 'Projets', 'text_domain' ),
		'archives'              => __( 'Archive des projets', 'text_domain' ),
		'parent_item_colon'     => __( 'Parent des projets', 'text_domain' ),
		'all_items'             => __( 'Tous les projets', 'text_domain' ),
		'add_new_item'          => __( 'Ajouter un projet', 'text_domain' ),
		'add_new'               => __( 'Ajouter un projet', 'text_domain' ),
		'new_item'              => __( 'Nouveau projet', 'text_domain' ),
		'edit_item'             => __( 'Modifier un projet', 'text_domain' ),
		'update_item'           => __( 'Mettre à jour le projet', 'text_domain' ),
		'view_item'             => __( 'Visionner le projet', 'text_domain' ),
		'search_items'          => __( 'Rechercher le projet', 'text_domain' ),
		'not_found'             => __( 'Aucun projet', 'text_domain' ),
		'not_found_in_trash'    => __( 'Projet introuvable dans la corbeille', 'text_domain' ),
		'featured_image'        => __( 'Image en vedette', 'text_domain' ),
		'set_featured_image'    => __( 'Mettre l\'image en vedette', 'text_domain' ),
		'remove_featured_image' => __( 'Retirer l\'image en vedette', 'text_domain' ),
		'use_featured_image'    => __( 'Utiliser comme image en vedette', 'text_domain' ),
		'insert_into_item'      => __( 'Insérer dans le projet', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Téléverser dans ce projet', 'text_domain' ),
		'items_list'            => __( 'Liste des projets', 'text_domain' ),
		'items_list_navigation' => __( 'Navigation de la liste de projets', 'text_domain' ),
		'filter_items_list'     => __( 'Filtrer', 'text_domain' ),
	);
	$args = array(
		'label'                 => __( 'Projet', 'text_domain' ),
		'description'           => __( 'Projets étudiants les plus populaires', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => array( 'title', ),
		'taxonomies'            => array( ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-media-interactive',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,		
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'rewrite'               => $rewrite,
		'capability_type'       => 'page',
	);

	register_post_type( 'projets_post_type', $args );

}
add_action( 'init', 'project_post_type', 0 );

// Register Custom Taxonomy
function logiciels_taxonomy() {

	$labels = array(
		'name'                       => _x( 'Logiciels', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Logiciel', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Logiciels', 'text_domain' ),
		'all_items'                  => __( 'Tous les logiciels', 'text_domain' ),
		'parent_item'                => __( 'Parent du logiciel', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent du logiciel:', 'text_domain' ),
		'new_item_name'              => __( 'Nouveau logiciel', 'text_domain' ),
		'add_new_item'               => __( 'Ajouter un nouveau logiciel', 'text_domain' ),
		'edit_item'                  => __( 'Modifier un logiciel', 'text_domain' ),
		'update_item'                => __( 'Mettre à jour le logiciel', 'text_domain' ),
		'view_item'                  => __( 'Visionner le logiciel', 'text_domain' ),
		'separate_items_with_commas' => __( 'Séparer les logiciels avec des virgules', 'text_domain' ),
		'add_or_remove_items'        => __( 'Ajouter ou supprimer un logiciel', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choisir parmis les plus utilisés', 'text_domain' ),
		'popular_items'              => __( 'Logiciels populaires', 'text_domain' ),
		'search_items'               => __( 'Rechercher un logiciel', 'text_domain' ),
		'not_found'                  => __( 'Introuvable', 'text_domain' ),
		'no_terms'                   => __( 'Aucun logiciel', 'text_domain' ),
		'items_list'                 => __( 'Liste des logiciels', 'text_domain' ),
		'items_list_navigation'      => __( 'Navigation de la liste des logiciels', 'text_domain' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'Logiciels', array( 'projets_post_type' ), $args );

}
add_action( 'init', 'logiciels_taxonomy', 0 );

if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page(array(
		'page_title' 	=> 'Options de dectim.ca',
		'menu_title'	=> 'Options du site',
		'menu_slug' 	=> 'theme-general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));
	
	
}