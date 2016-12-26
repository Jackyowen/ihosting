<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'ihosting');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'ozD%[BrE>z/w`/hV9Ge.W()Q`a])IJ#!-]BC.=PEK@q.bl+ dzQ9g>e1U[hUyJkK');
define('SECURE_AUTH_KEY',  't=W(b@H3[DRKlc.8cZh2Om+y&+^ALX/>yQX#R).(#Z--Z/0}J9p^Wp5-ig*D=_M4');
define('LOGGED_IN_KEY',    '*725hu}Xsw0b{{%I{e|T/cX9>))(c:@;VfUt67F0DaK0BGd?14;}9.C:YddJ=MAi');
define('NONCE_KEY',        ']ZY6qdRiWOj0- 9Ks)WgbtP+QT%.MS~,c_h<UUt;skqv7Srb,<|941LLGv~>Hu][');
define('AUTH_SALT',        'iqF4_boM&H}<a!GFsRRH~V`A:Az,)+^+^^F.TSUs8!:WUSQPz1^F`D^H&ze_.DHS');
define('SECURE_AUTH_SALT', '8o.jN%ES-nz`>_m_^72I[<#%J}T{dy&mnS-t<gwT{Is%ezeI+29>^jC|+nS#ZaYs');
define('LOGGED_IN_SALT',   '.,-z0c2JO+b-0`z3KF_f[uLfokDZqb-LlFR8]&nyq>g-nYp=>7G1TOQ3-[0wYj/^');
define('NONCE_SALT',       'H|OGeNs|^_SM.~_*6Dvo--M7Q+e5V5AZyus|pxGeK`?pk@)eNBALi/xFjT`tn}+j');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'ih_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', true);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
