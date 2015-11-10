<?php
/**
 * La configuration de base de votre installation WordPress.
 *
 * Le script de création wp-config.php utilise ce fichier lors de l'installation.
 * Vous n'avez pas à utiliser l'interface web, vous pouvez directement
 * renommer ce fichier en "wp-config.php" et remplir les variables à la main.
 * 
 * Ce fichier contient les configurations suivantes :
 * 
 * * réglages MySQL ;
 * * clefs secrètes ;
 * * préfixe de tables de la base de données ;
 * * ABSPATH.
 * 
 * @link https://codex.wordpress.org/Editing_wp-config.php 
 * 
 * @package WordPress
 */

// ** Réglages MySQL - Votre hébergeur doit vous fournir ces informations. ** //
/** Nom de la base de données de WordPress. */
define('DB_NAME', 'e0977198_dectim');

/** Utilisateur de la base de données MySQL. */
define('DB_USER', 'e0977198_dectim');

/** Mot de passe de la base de données MySQL. */
define('DB_PASSWORD', 'Dectim2015');

/** Adresse de l'hébergement MySQL. */
define('DB_HOST', 'jalphonso.dectim.ca');

/** Jeu de caractères à utiliser par la base de données lors de la création des tables. */
define('DB_CHARSET', 'utf8mb4');

/** Type de collation de la base de données. 
  * N'y touchez que si vous savez ce que vous faites. 
  */
define('DB_COLLATE', '');

/**#@+
 * Clefs uniques d'authentification et salage.
 *
 * Remplacez les valeurs par défaut par des phrases uniques !
 * Vous pouvez générer des phrases aléatoires en utilisant 
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ le service de clefs secrètes de WordPress.org}.
 * Vous pouvez modifier ces phrases à n'importe quel moment, afin d'invalider tous les cookies existants.
 * Cela forcera également tous les utilisateurs à se reconnecter.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '|PB|y1B?D`)g?_vK!Q^+YY1`yls(3.71Ig]]HCCsZ@xHycVf2-.GN%/.1`vE=iq,');
define('SECURE_AUTH_KEY',  'kmB@!4z(7[tqs^)H9#5:I;}qe0gGj.l.y{wT~X5K1C}R`mr3(iQn4`1x$[Q+}>!v');
define('LOGGED_IN_KEY',    'fwBl&vL|ri~np<s/Z77]I4?_[~`h{;T2Fkdz1BVv*TZLx7FMy?SAr:/4R~c$z{#}');
define('NONCE_KEY',        'nczxJTUyJp7hfz( S70z==s4|A)]0OAL[zG_W;~:]hCaf_M!Ms~*teLX;hL;XDl!');
define('AUTH_SALT',        '=q.LcZhQW[Hn[#3af)dI4@`szpLG$k?29L1rUfX@@2#P#x7Tja`Qj[l0/a&c!<8 ');
define('SECURE_AUTH_SALT', 'G?-!D|iv#3ld46b+?p/;k&SEX-i!+6p;TYC;HDnVo_:C,`bdCah]@EB|tcONoq4T');
define('LOGGED_IN_SALT',   'c}J;4J_|+Kk|BIV@Q>wv~yG%~` EK$)B5=2UWwFZ`txD7*&%BCu4?<&bcwz-}qR(');
define('NONCE_SALT',       'ieif%mf5q}hfWHr_CSm[1OUt>l,6]G#hW++_aW[P)9G: 1*to|2~Ht1ju-ia|3[3');
/**#@-*/

/**
 * Préfixe de base de données pour les tables de WordPress.
 *
 * Vous pouvez installer plusieurs WordPress sur une seule base de données
 * si vous leur donnez chacune un préfixe unique. 
 * N'utilisez que des chiffres, des lettres non-accentuées, et des caractères soulignés!
 */
$table_prefix  = 'wp_';

/** 
 * Pour les développeurs : le mode déboguage de WordPress.
 * 
 * En passant la valeur suivante à "true", vous activez l'affichage des
 * notifications d'erreurs pendant votre essais.
 * Il est fortemment recommandé que les développeurs d'extensions et
 * de thèmes se servent de WP_DEBUG dans leur environnement de 
 * développement.
 * 
 * Pour obtenir plus d'information sur les constantes 
 * qui peuvent être utilisée pour le déboguage, consultez le Codex.
 * 
 * @link https://codex.wordpress.org/Debugging_in_WordPress 
 */ 
define('WP_DEBUG', false); 

/* C'est tout, ne touchez pas à ce qui suit ! Bon blogging ! */

/** Chemin absolu vers le dossier de WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Réglage des variables de WordPress et de ses fichiers inclus. */
require_once(ABSPATH . 'wp-settings.php');

#Empêcher les modifications via l'administration
define( 'DISALLOW_FILE_EDIT', true );