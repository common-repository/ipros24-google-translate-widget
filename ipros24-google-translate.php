<?php

/*
	Plugin Name: iPROS24 Google Translate widget
	Plugin URI: http://ipros24.ru/wordpress/#ipros24-google-translate
	Description: iPROS24 Google Translate widget for WordPress.
	Version: 1.12.2
	Author: A. Kirillov
	Author URI: http://ipros24.ru/
	License: GPL2
	Text Domain: ipros24-google-translate
	Domain Path: /languages
*/

if (!defined ("ABSPATH"))
	exit;

require_once "assets/php/utils.php";

class iPROS24_google_translate_widget extends WP_Widget	{

	function __construct ()	{

		parent::__construct (

			"ipros24_google_translate_widget",
			__ ("iPROS24 Google Translate", iPROS24_google_translate_plugin::$text_domain),

			array (

				"description" => __ ("Displays Google Translate widget with flags in a sidebar.", iPROS24_google_translate_plugin::$text_domain),
				"classname" => "ipros24-google-translate-cn"
			)
		);
	}

	function widget ($args, $instance)	{

		extract ($args);

		$cn = "widget_ipros24_google_translate_widget ";
		if (isset ($instance["transparent"]) && $instance["transparent"])
			$cn .= "ipros24-google-translate-transparent ";

		$before_widget = str_replace ("ipros24-google-translate-cn", $cn, $before_widget);

		$title = $instance["title"];
		$title = apply_filters ("widget_title", $title, $instance, $this->id_base);

		echo $before_widget;
		if ($title)
			echo $before_title.esc_html__ ($title, iPROS24_google_translate_plugin::$text_domain).$after_title;

		$opt = get_option ("ipros24-google-translate-options");
		if ($opt["layout"] == "flags")
			echo iPROS24_google_translate_plugin::widget ($instance);
		else
			echo "<div id='google_translate_element'></div>";

		echo $after_widget;
	}

	function form ($instance)	{

		$instance = wp_parse_args ($instance, array ("title" => ""));
		$opt = get_option ("ipros24-google-translate-options");

		$form =	"<p>".
				"<label for='".$this->get_field_id ("title")."'>".esc_html__ ("Title:", iPROS24_google_translate_plugin::$text_domain)."</label>".
				"<input	".
					"type='text' ".
					"class='widefat' ".
					"id='".$this->get_field_id ("title")."' ".
					"name='".$this->get_field_name ("title")."' ".
					"value='".esc_attr ($instance["title"])."' ".
				"/>".
			"</p>".

			"<p>".
				"<input ".
					"type='checkbox' ".
					"class='checkbox' ".
					"id='".$this->get_field_id ("show-language-codes")."' ".
					"name='".$this->get_field_name ("show-language-codes")."' ".
					"value='1' ".
					checked ("1", isset ($instance["show-language-codes"]) ? $instance["show-language-codes"] : "", FALSE).
					($opt["layout"] != "flags" ? "disabled" : "").
				">"." ".
				"<label for='".$this->get_field_id ("show-language-codes")."'>".
					esc_html__ ("Show language codes", iPROS24_google_translate_plugin::$text_domain).
				"</label>".
			"</p>".

			"<p>".
				"<input ".
					"type='checkbox' ".
					"class='checkbox' ".
					"id='".$this->get_field_id ("transparent")."' ".
					"name='".$this->get_field_name ("transparent")."' ".
					"value='1' ".
					checked ("1", isset ($instance["transparent"]) ? $instance["transparent"] : "", FALSE).
				">"." ".
				"<label for='".$this->get_field_id ("transparent")."'>".
					esc_html__ ("Transparent", iPROS24_google_translate_plugin::$text_domain).
				"</label>".
			"</p>".

			"<p>".
				"<label for='".$this->get_field_id ("attribution")."'>".esc_html__ ("Attribution style:", iPROS24_google_translate_plugin::$text_domain)."</label>"." ".
				"<select id='".$this->get_field_id ("attribution")."' name='".$this->get_field_name ("attribution")."'>".
					"<option value='color' ".selected ("color", isset ($instance["attribution"]) ? $instance["attribution"] : "", FALSE).">".esc_html_x ("Color", "attribution", iPROS24_google_translate_plugin::$text_domain)."</option>".
					"<option value='grayscale' ".selected ("grayscale", isset ($instance["attribution"]) ? $instance["attribution"] : "", FALSE).">".esc_html_x ("Grayscale", "attribution", iPROS24_google_translate_plugin::$text_domain)."</option>".
					"<option value='white' ".selected ("white", isset ($instance["attribution"]) ? $instance["attribution"] : "", FALSE).">".esc_html_x ("White", "attribution", iPROS24_google_translate_plugin::$text_domain)."</option>".
					"<option value='none' ".selected ("none", isset ($instance["attribution"]) ? $instance["attribution"] : "", FALSE).">".esc_html_x ("None", "attribution", iPROS24_google_translate_plugin::$text_domain)."</option>".
				"</select>".
			"</p>";

		echo $form;
	}
}

class iPROS24_google_translate_plugin extends iPROS24_WP_Plugin	{

	static	$text_domain;

	protected static	$RTL = array ("ar", "fa", "iw", "ur", "yi"),
				$LANGUAGE = array (

					"af" => array ("locale" => "af_ZA", "name" => "Afrikaans"),
					"ar" => array ("locale" => "ar_EG", "name" => "العربية"),
					"az" => array ("locale" => "az_AZ", "name" => "azərbaycan dili"),
					"be" => array ("locale" => "be_BY", "name" => "беларуская мова"),
					"bg" => array ("locale" => "bg_BG", "name" => "български език"),
					"bn" => array ("locale" => "bn_BD", "name" => "বাংলা"),
					"bs" => array ("locale" => "bs_BA", "name" => "bosanski jezik"),
					"ca" => array ("locale" => "ca_ES", "name" => "català"),
					"cs" => array ("locale" => "cs_CZ", "name" => "čeština"),
					"cy" => array ("locale" => "cy_GB", "name" => "Cymraeg"),
					"da" => array ("locale" => "da_DK", "name" => "dansk"),
					"de" => array ("locale" => "de_DE", "name" => "Deutsch"),
					"el" => array ("locale" => "el_GR", "name" => "ελληνικά"),
					"en" => array ("locale" => "en_GB", "name" => "English"),
					"es" => array ("locale" => "es_ES", "name" => "español"),
					"et" => array ("locale" => "et_EE", "name" => "eesti"),
					"eu" => array ("locale" => "eu_ES", "name" => "euskara"),
					"fa" => array ("locale" => "fa_IR", "name" => "فارسی"),
					"fi" => array ("locale" => "fi_FI", "name" => "suomi"),
					"fr" => array ("locale" => "fr_FR", "name" => "français"),
					"ga" => array ("locale" => "ga_IE", "name" => "Gaeilge"),
					"gl" => array ("locale" => "gl_ES", "name" => "galego"),
					"gu" => array ("locale" => "gu_IN", "name" => "ગુજરાતી"),
					"ha" => array ("locale" => "ha_NG", "name" => "Hausa"),
					"hi" => array ("locale" => "hi_IN", "name" => "हिन्दी"),
					"hr" => array ("locale" => "hr_HR", "name" => "hrvatski jezik"),
					"ht" => array ("locale" => "ht_HT", "name" => "Kreyòl ayisyen"),
					"hu" => array ("locale" => "hu_HU", "name" => "magyar"),
					"hy" => array ("locale" => "hy_AM", "name" => "Հայերեն"),
					"id" => array ("locale" => "id_ID", "name" => "Bahasa Indonesia"),
					"ig" => array ("locale" => "ig_NG", "name" => "Asụsụ Igbo"),
					"is" => array ("locale" => "is_IS", "name" => "Íslenska"),
					"it" => array ("locale" => "it_IT", "name" => "italiano"),
					"iw" => array ("locale" => "iw_IL", "name" => "עברית"),
					"ja" => array ("locale" => "ja_JP", "name" => "日本語"),
					"ka" => array ("locale" => "ka_GE", "name" => "ქართული"),
					"kk" => array ("locale" => "kk_KZ", "name" => "қазақ тілі"),
					"km" => array ("locale" => "km_KH", "name" => "ខ្មែរ"),
					"kn" => array ("locale" => "kn_IN", "name" => "ಕನ್ನಡ"),
					"ko" => array ("locale" => "ko_KR", "name" => "한국어"),
					"lo" => array ("locale" => "lo_LA", "name" => "ພາສາລາວ"),
					"lt" => array ("locale" => "lt_LT", "name" => "lietuvių kalba"),
					"lv" => array ("locale" => "lv_LV", "name" => "latviešu valoda"),
					"mg" => array ("locale" => "mg_MG", "name" => "fiteny malagasy"),
					"mi" => array ("locale" => "mi_NZ", "name" => "te reo Māori"),
					"mk" => array ("locale" => "mk_MK", "name" => "македонски јазик"),
					"ml" => array ("locale" => "ml_IN", "name" => "മലയാളം"),
					"mn" => array ("locale" => "mn_MN", "name" => "монгол"),
					"mr" => array ("locale" => "mr_IN", "name" => "मराठी"),
					"ms" => array ("locale" => "ms_MY", "name" => "bahasa Melayu"),
					"mt" => array ("locale" => "mt_MT", "name" => "Malti"),
					"my" => array ("locale" => "my_MM", "name" => "ဗမာစာ"),
					"ne" => array ("locale" => "ne_NP", "name" => "नेपाली"),
					"nl" => array ("locale" => "nl_NL", "name" => "Nederlands"),
					"no" => array ("locale" => "no_NO", "name" => "Norsk"),
					"pa" => array ("locale" => "pa_PK", "name" => "ਪੰਜਾਬੀ"),
					"pl" => array ("locale" => "pl_PL", "name" => "język polski"),
					"pt" => array ("locale" => "pt_BR", "name" => "português"),
					"ro" => array ("locale" => "ro_RO", "name" => "limba română"),
					"ru" => array ("locale" => "ru_RU", "name" => "Русский"),
					"si" => array ("locale" => "si_LK", "name" => "සිංහල"),
					"sk" => array ("locale" => "sk_SK", "name" => "slovenčina"),
					"sl" => array ("locale" => "sl_SI", "name" => "slovenščina"),
					"so" => array ("locale" => "so_SO", "name" => "Soomaaliga"),
					"sq" => array ("locale" => "sq_AL", "name" => "Shqip"),
					"sr" => array ("locale" => "sr_RS", "name" => "српски језик"),
					"st" => array ("locale" => "st_ZA", "name" => "Sesotho"),
					"sv" => array ("locale" => "sv_SE", "name" => "svenska"),
					"ta" => array ("locale" => "ta_IN", "name" => "தமிழ்"),
					"te" => array ("locale" => "te_IN", "name" => "తెలుగు"),
					"tg" => array ("locale" => "tg_TJ", "name" => "тоҷикӣ"),
					"th" => array ("locale" => "th_TH", "name" => "ไทย"),
					"tl" => array ("locale" => "tl_PH", "name" => "Wikang Tagalog"),
					"tr" => array ("locale" => "tr_TR", "name" => "Türkçe"),
					"uk" => array ("locale" => "uk_UA", "name" => "українська мова"),
					"ur" => array ("locale" => "ur_PK", "name" => "اردو"),
					"uz" => array ("locale" => "uz_UZ", "name" => "Oʻzbek"),
					"vi" => array ("locale" => "vi_VN", "name" => "Việt Nam"),
					"yi" => array ("locale" => "yi_US", "name" => "ייִדיש"),
					"yo" => array ("locale" => "yo_NG", "name" => "Yorùbá"),

					"zh-CN" => array ("locale" => "zh_CN", "name" => "中文"),
					"zh-TW" => array ("locale" => "zh_TW", "name" => "中文"),

					"zu" => array ("locale" => "zu_ZA", "name" => "isiZulu")
				);

	const	MATCH = "/^\/(.*)\/([^-]*)/",
		MATCH_LOCALE = "/^\/(.*)\/(.*)/";

	function __construct ()	{

//		self::$text_domain = basename (__DIR__);
		self::$text_domain = "ipros24-google-translate";

		$this->plugin_dir_path = plugin_dir_path (__FILE__);
		$this->plugin_dir_url = plugin_dir_url (__FILE__);

		parent::__construct ();

		register_activation_hook (__FILE__, array ($this, "register_activation_hook"));
		register_deactivation_hook (__FILE__, array ($this, "register_deactivation_hook"));

		add_action ("plugins_loaded", array ($this, "plugins_loaded"));
		add_action ("admin_init", array ($this, "admin_init"));
		add_action ("admin_menu", array ($this, "admin_menu"));

		add_action ("init", array ($this, "init"));

		add_action ("wp_head", array ($this, "wp_head"));
		add_action ("login_head", array ($this, "login_head"));
		add_action ("admin_head", array ($this, "admin_head"));

		add_action ("wp_footer", array ($this, "wp_footer"));
		add_action ("login_footer", array ($this, "login_footer"));
		add_action ("admin_footer", array ($this, "admin_footer"));

		add_action ("widgets_init", array ($this, "widgets_init"));
		add_action ("wp_enqueue_scripts", array ($this, "wp_enqueue_scripts"));
		add_action ("login_enqueue_scripts", array ($this, "login_enqueue_scripts"));
		add_action ("admin_enqueue_scripts", array ($this, "admin_enqueue_scripts"));

		add_filter ("locale", array ($this, "locale"));
		add_filter ("body_class", array ($this, "body_class"));
		add_filter ("get_available_languages", array ($this, "get_available_languages"), 10, 2);
		add_filter ("quicktags_settings", array ($this, "quicktags_settings"), 10, 2);

		add_filter ("plugin_action_links_".plugin_basename (__FILE__), array ($this, "plugin_action_links"), 10, 4);

		add_shortcode ("ipros24_google_translate", array ($this, "ipros24_google_translate"));
	}

	static function domain ($host)	{

		$tmp = explode (".", $host);
		if (count ($tmp) > 2)
			array_shift ($tmp);

		$domain = join (".", $tmp);

//		iPROS24_Utils::log (" host = $host domain = $domain");

		return $domain;
	}

	static function is_rtl ($lang)	{

//		iPROS24_Utils::log (" lang = $lang");

		return in_array ($lang, self::$RTL);
	}

	static function is_login ()	{

		global $pagenow;

		return $pagenow == "wp-login.php";
	}

	static function get_language ()	{

		$val = isset ($_COOKIE["googtrans"]) ? $_COOKIE["googtrans"] : "";

		$_COOKIE["googtrans"] = "";
		$lang = substr (get_locale (), 0, 2);
		$_COOKIE["googtrans"] = $val;

		return $lang;
	}

	static function widget ($atts)	{

		$opt = get_option ("ipros24-google-translate-options");

		$lang = isset ($opt["included-languages"]) && $opt["included-languages"] ? explode (",", $opt["included-languages"]) : array_keys (self::$LANGUAGE);
		$lang = array_unique (array_merge ($lang, array ($opt["site-language"])));

		$locale = get_locale ();
		if ((!isset ($_COOKIE["googtrans"]) || !$_COOKIE["googtrans"]) && isset ($opt["multilanguage-site"]) && $opt["multilanguage-site"])
			$locale = "";

		$tmp = "";
		foreach ($lang as $l)

			$tmp .=	"<a ".
					"href='".esc_url (add_query_arg ("lang", urlencode ($l), $_SERVER["REQUEST_URI"]))."' ".
					(self::$LANGUAGE[$l]["locale"] == $locale ? "class='active-language' " : "").
					"rel='nofollow' ".
				">".
					"<span>".
						"<span ".
							"title='".esc_attr (sprintf (

								__ (isset ($atts["show-language-codes"]) && $atts["show-language-codes"] ? '%1$s (%2$s)' : '%s', self::$text_domain),
								 self::$LANGUAGE[$l]["name"],
								 $l
							))."' ".

							"class='".esc_attr (self::$LANGUAGE[$l]["locale"]." ".(self::is_rtl ($l) ? "rtl" : ""))."' ".
						">".
						"</span>".
					"</span>".
				"</a>";

		$cn = "ipros24-google-translate-attribution ";
		if (isset ($atts["attribution"]) && $atts["attribution"])
			$cn .= "ipros24-".$atts["attribution"]." ";

		return	"<div class='ipros24-google-translate-widget notranslate'>".
				"<div class='ipros24-google-translate-flags'>$tmp</div>".
				"<div class='$cn'>".
					"<a href='https://translate.google.com/' target='_blank' rel='noopener'></a>".
				"</div>".
			"</div>";
	}

	function register_activation_hook ()	{

		$opt = get_option ("ipros24-google-translate-options", array (

			"layout" => "flags",
			"auto-display" => TRUE
		));

		$opt["site-language"] = self::get_language ();

		update_option ("ipros24-google-translate-options", $opt);
		update_option ("ipros24-google-translate-options-wordpress", get_option ("ipros24-google-translate-options-wordpress", array (

//			"translate-admin-panel" => TRUE,
			"translate-login-page" => TRUE
		)));
	}

	function register_deactivation_hook ()	{

//		delete_option ("ipros24-google-translate-options");
//		delete_option ("ipros24-google-translate-options-wordpress");
	}

	function plugins_loaded ()	{

		load_plugin_textdomain (self::$text_domain, FALSE, dirname (plugin_basename (__FILE__))."/languages/");

		if (!isset ($_GET["lang"]))
			return;

		$lang = stripslashes ($_GET["lang"]);
		if (isset (self::$LANGUAGE[$lang]) && self::$LANGUAGE[$lang])	{

			$opt = get_option ("ipros24-google-translate-options");
			$_COOKIE["googtrans"] = "/".$opt["site-language"]."/".$lang;

			setrawcookie ("googtrans", $_COOKIE["googtrans"], 0, "/");
			setrawcookie ("googtrans", $_COOKIE["googtrans"], 0, "/", self::domain ($_SERVER["SERVER_NAME"]));
		}
		else	{

			unset ($_COOKIE["googtrans"]);

			setcookie ("googtrans", "", -1, "/");
			setcookie ("googtrans", "", -1, "/", self::domain ($_SERVER["SERVER_NAME"]));
		}
	}

	function admin_init ()	{

		register_setting ("ipros24-google-translate", "ipros24-google-translate-options", array ($this, "sanitize_callback"));
		register_setting ("ipros24-google-translate", "ipros24-google-translate-options-wordpress");

		add_settings_section (

			"ipros24-google-translate-options",
			esc_html__ ("Google settings", self::$text_domain),

			function ()	{

				echo esc_html__ ("Google Website Translator settings", iPROS24_google_translate_plugin::$text_domain);
			},

			$this->options_page
		);

		add_settings_section (

			"ipros24-google-translate-options-wordpress",
			esc_html__ ("WordPress settings", self::$text_domain),

			function ()	{

				echo esc_html__ ("WordPress settings", iPROS24_google_translate_plugin::$text_domain);
			},

			$this->options_page
		);

		$opt = get_option ("ipros24-google-translate-options");
		add_settings_field (

			"languages",
			esc_html__ ("Languages", self::$text_domain),
			array ($this, "text_field_callback"),
			$this->options_page,
			"ipros24-google-translate-options",
			array (

				"field" => array (

					array (

						"name" => "ipros24-google-translate-options[site-language]",
						"value" => $opt["site-language"],
						"label" => __ ("Website language", self::$text_domain),
						"attributes" => "disabled"
					),

					array (

						"name" => "ipros24-google-translate-options[included-languages]",
						"value" => isset ($opt["included-languages"]) ? $opt["included-languages"] : "",
						"label" => __ ("Translation languages", self::$text_domain)
					)
				),

				"description" => __ ("Enter comma-separated list of language codes or leave this blank for all available languages.", self::$text_domain)
			)
		);

		add_settings_field (

			"layout",
			esc_html__ ("Layout", self::$text_domain),
			array ($this, "radio_field_callback"),
			$this->options_page,
			"ipros24-google-translate-options",
			array (

				"field" => array (

					array (

						"name" => "ipros24-google-translate-options[layout]",
						"value" => "google-inline-vertical",
						"label" => __ ("Google vertical", self::$text_domain),
						"attributes" => $opt["layout"] == "google-inline-vertical" ? "checked" : ""
					),

					array (

						"name" => "ipros24-google-translate-options[layout]",
						"value" => "google-inline-dropdown",
						"label" => __ ("Google dropdown", self::$text_domain),
						"attributes" => $opt["layout"] == "google-inline-dropdown" ? "checked" : ""
					),

					array (

						"name" => "ipros24-google-translate-options[layout]",
						"value" => "flags",
						"label" => __ ("Flags", self::$text_domain),
						"attributes" => $opt["layout"] == "flags" ? "checked" : ""
					)
				),

				"description" => ""
			)
		);

		add_settings_field (

			"advanced",
			esc_html__ ("Advanced", self::$text_domain),
			array ($this, "checkbox_field_callback"),
			$this->options_page,
			"ipros24-google-translate-options",
			array (

				"legend" => __ ("Advanced", self::$text_domain),
				"field" => array (

					array (

						"name" => "ipros24-google-translate-options[auto-display]",
						"value" => isset ($opt["auto-display"]) ? $opt["auto-display"] : "",
						"label" => __ ("Automatically display translation banner to users speaking other languages", self::$text_domain)
					),

					array (

						"name" => "ipros24-google-translate-options[multilanguage-site]",
						"value" => isset ($opt["multilanguage-site"]) ? $opt["multilanguage-site"] : "",
						"label" => __ ("The site contains content in multiple languages", self::$text_domain)
					)
				),

				"description" => ""
			)
		);

		add_settings_field (

			"customization",
			esc_html__ ("Customization meta tag", self::$text_domain),
			array ($this, "text_field_callback"),
			$this->options_page,
			"ipros24-google-translate-options",
			array (

				"field" => array (

					array (

						"name" => "ipros24-google-translate-options[customization-meta-tag]",
						"value" => isset ($opt["customization-meta-tag"]) ? $opt["customization-meta-tag"] : "",
						"label" => ""
					)
				)
			)
		);

		add_settings_field (

			"analytics",
			esc_html__ ("Analytics Web Property ID", self::$text_domain),
			array ($this, "text_field_callback"),
			$this->options_page,
			"ipros24-google-translate-options",
			array (

				"field" => array (

					array (

						"name" => "ipros24-google-translate-options[google-analytics-id]",
						"value" => isset ($opt["google-analytics-id"]) ? $opt["google-analytics-id"] : "",
						"label" => ""
					)
				)
			)
		);

		$opt = get_option ("ipros24-google-translate-options-wordpress");
 		add_settings_field (

			"test-phrase",
			esc_html__ ("Test phrase", self::$text_domain),
			array ($this, "text_field_callback"),
			$this->options_page,
			"ipros24-google-translate-options-wordpress",
			array (

				"field" => array (

					array (

						"name" => "ipros24-google-translate-options-wordpress[test-phrase]",
						"value" => isset ($opt["test-phrase"]) ? $opt["test-phrase"] : "",
						"label" => ""
					)
				),

				"description" => __ ("Enter a common word or phrase in the language of your website. This will be used to trigger resize of the translated page.", self::$text_domain)
			)
		);

		add_settings_field (

			"other-options",
			esc_html__ ("Other options", self::$text_domain),
			array ($this, "checkbox_field_callback"),
			$this->options_page,
			"ipros24-google-translate-options-wordpress",
			array (

				"legend" => __ ("Other options", self::$text_domain),
				"field" => array (

					array (

						"name" => "ipros24-google-translate-options-wordpress[translate-admin-panel]",
						"value" => isset ($opt["translate-admin-panel"]) ? $opt["translate-admin-panel"] : "",
						"label" => __ ("Translate Administration panel", self::$text_domain)
					),

					array (

						"name" => "ipros24-google-translate-options-wordpress[translate-login-page]",
						"value" => isset ($opt["translate-login-page"]) ? $opt["translate-login-page"] : "",
						"label" => __ ("Translate Login page", self::$text_domain)
					),

					array (

						"name" => "ipros24-google-translate-options-wordpress[hide-translation-banner]",
						"value" => isset ($opt["hide-translation-banner"]) ? $opt["hide-translation-banner"] : "",
						"label" => __ ("Hide translation banner", self::$text_domain)
					),

					array (

						"name" => "ipros24-google-translate-options-wordpress[reload-page]",
						"value" => isset ($opt["reload-page"]) ? $opt["reload-page"] : "",
						"label" => __ ("Reload page if needed", self::$text_domain)
					),

					array (

						"name" => "ipros24-google-translate-options-wordpress[quicktags-fix]",
						"value" => isset ($opt["quicktags-fix"]) ? $opt["quicktags-fix"] : "",
						"label" => __ ("Quicktags fix (check if Google Translator gets stuck on the Dashboard)", self::$text_domain)
					)
				),

				"description" => ""
			)
		);
	}

	function sanitize_callback ($opt)	{

		if (!isset ($opt["site-language"]) || !$opt["site-language"])
			$opt["site-language"] = self::get_language ();

		$opt["site-language"] = preg_replace ("/\s+/", "", $opt["site-language"]);
		$opt["included-languages"] = preg_replace ("/\s+/", "", $opt["included-languages"]);

		$lang = $opt["included-languages"] ? explode (",", $opt["included-languages"]) : array ();
		$lang = array_unique (array_merge ($lang, array ($opt["site-language"])));

		$unknown = array ();
		foreach ($lang as $l)
			if (!isset (self::$LANGUAGE[$l]) || !self::$LANGUAGE[$l])
				$unknown[] = $l;

		if ($unknown)

			add_settings_error (

				"ipros24-google-translate-options",
				"unknown-languages",
				sprintf (__ ("Unknown languages: %s.", self::$text_domain), join (",", $unknown))
			);

		return $opt;
	}

	function admin_menu ()	{

		add_options_page (

			__ ("Google Translate", self::$text_domain),
			__ ("Google Translate", self::$text_domain),
			"manage_options",
			$this->options_page,
			array ($this, "options")
		);
	}

	function options ()	{

		echo	"<div class='wrap'>".
				"<h2>".esc_html__ ("Google Translate settings", self::$text_domain)."</h2>".
				"<form method='POST' action='options.php'>";

					settings_fields ("ipros24-google-translate");
					do_settings_sections ($this->options_page);
					submit_button ();

		echo		"</form>".
			"</div>";
	}

	function init ()	{

		global $wp_locale;

		$opt = get_option ("ipros24-google-translate-options-wordpress");
		if (is_admin () && (!isset ($opt["translate-admin-panel"]) || !$opt["translate-admin-panel"]))
			;
		else
		if (self::is_login () && (!isset ($opt["translate-login-page"]) || !$opt["translate-login-page"]))
			;
		else	{

			$direction = preg_match (self::MATCH, isset ($_COOKIE["googtrans"]) ? $_COOKIE["googtrans"] : "", $match) && self::is_rtl ($match[2]) ? "rtl" : "ltr";
			$wp_locale->text_direction = $direction;
		}
	}

	function wp_head ()	{

		global $META_SLASH;

		$LF = "\n";

		$opt = get_option ("ipros24-google-translate-options-wordpress");
		if (isset ($opt["hide-translation-banner"]) && $opt["hide-translation-banner"] || is_customize_preview ())
			echo	"<style type='text/css'>".
					"iframe.goog-te-banner-frame.skiptranslate {".
						"display: none;".
					"}".
				"</style>$LF";

		$opt = get_option ("ipros24-google-translate-options");
		if (isset ($opt["customization-meta-tag"]) && $opt["customization-meta-tag"])
			echo "<meta name='google-translate-customization' content='".esc_attr ($opt["customization-meta-tag"])."'$META_SLASH>$LF";
	}

	function login_head ()	{

		$opt = get_option ("ipros24-google-translate-options-wordpress");
		if (isset ($opt["translate-login-page"]) && $opt["translate-login-page"])
			$this->wp_head ();
	}

	function admin_head ()	{

		$opt = get_option ("ipros24-google-translate-options-wordpress");
		if (isset ($opt["translate-admin-panel"]) && $opt["translate-admin-panel"])
			$this->wp_head ();
	}

	function wp_footer ()	{

		global $is_bot, $current_user;

		$opt = get_option ("ipros24-google-translate-options-wordpress");
		echo "<div id='ipros24-google-translate-test'>".esc_html (isset ($opt["test-phrase"]) ? $opt["test-phrase"] : "")."</div>";

		if ($is_bot || in_array ("administrator", $current_user->roles))
			return;

		$opt = get_option ("ipros24-google-translate-options");
		$google_opt = "pageLanguage: \"".addslashes ($opt["site-language"])."\"";

		if (isset ($opt["included-languages"]) && $opt["included-languages"])
			$google_opt .= ", includedLanguages: \"".addslashes ($opt["included-languages"])."\"";

		if ($opt["layout"] == "google-inline-dropdown")
			$google_opt .= ", layout: google.translate.TranslateElement.InlineLayout.SIMPLE";

		if (!isset ($opt["auto-display"]) || !$opt["auto-display"])
			$google_opt .= ", autoDisplay: false";

		if (isset ($opt["multilanguage-site"]) && $opt["multilanguage-site"])
			$google_opt .= ", multilanguagePage: true";

		if (isset ($opt["google-analytics-id"]) && $opt["google-analytics-id"])
			$google_opt .= ", gaTrack: true, gaId: \"".addslashes ($opt["google-analytics-id"])."\"";

		echo	"<script type='text/javascript'>".

				"function googleTranslateElementInit ()	{".

					"new google.translate.TranslateElement ({".$google_opt."}, \"google_translate_element\");".
				"}".

			"</script>".
			"<!--script type='text/javascript' src='//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit' async='async'></script-->";
	}

	function login_footer ()	{

		$opt = get_option ("ipros24-google-translate-options-wordpress");
		if (isset ($opt["translate-login-page"]) && $opt["translate-login-page"])
			$this->wp_footer ();
	}

	function admin_footer ()	{

		$opt = get_option ("ipros24-google-translate-options-wordpress");
		if (isset ($opt["translate-admin-panel"]) && $opt["translate-admin-panel"])
			$this->wp_footer ();
	}

	function widgets_init ()	{

		register_widget ("iPROS24_google_translate_widget");
	}

	function wp_enqueue_scripts ()	{

		parent::wp_enqueue_scripts ();

		$l10n = array (

			"RTL" => self::$RTL
		);

		$opt = get_option ("ipros24-google-translate-options");
		$l10n = array_merge ($l10n, array (

			"SITE_LANGUAGE" => isset ($opt["site-language"]) ? $opt["site-language"] : "",
			"MULTILANGUAGE" => isset ($opt["multilanguage-site"]) ? $opt["multilanguage-site"] : ""
		));

		$opt = get_option ("ipros24-google-translate-options-wordpress");
		$l10n = array_merge ($l10n, array (

			"RELOAD_PAGE" => isset ($opt["reload-page"]) ? $opt["reload-page"] : ""
		));

		wp_localize_script ("ipros24-google-translate-script", "ipros24_google_translate", $l10n);
	}

	function login_enqueue_scripts ()	{

		$opt = get_option ("ipros24-google-translate-options-wordpress");
		if (isset ($opt["translate-login-page"]) && $opt["translate-login-page"])
			$this->wp_enqueue_scripts ();
	}

	function admin_enqueue_scripts ()	{

		$opt = get_option ("ipros24-google-translate-options-wordpress");
		if (isset ($opt["translate-admin-panel"]) && $opt["translate-admin-panel"])
			$this->wp_enqueue_scripts ();

		wp_enqueue_style ("ipros24-google-translate-admin-style", $this->plugin_dir_url."assets/css/my-admin.css");
		if (is_rtl ())
			wp_enqueue_style ("ipros24-google-translate-admin-rtl-style", $this->plugin_dir_url."assets/css/my-admin-rtl.css");
	}

	function locale ($locale)	{

		if (preg_match (self::MATCH_LOCALE, isset ($_COOKIE["googtrans"]) ? $_COOKIE["googtrans"] : "", $match) && isset (self::$LANGUAGE[$match[2]]) && self::$LANGUAGE[$match[2]])
			$locale = self::$LANGUAGE[$match[2]]["locale"];

//		iPROS24_Utils::log (" locale = $locale");

		return $locale;
	}

	function body_class ($classes)	{

		if (preg_match (self::MATCH_LOCALE, isset ($_COOKIE["googtrans"]) ? $_COOKIE["googtrans"] : "", $match) && isset (self::$LANGUAGE[$match[2]]) && self::$LANGUAGE[$match[2]])
			$classes[] = "ipros24-translated";

		return $classes;
	}

	function get_available_languages ($languages, $dir)	{

		global $pagenow;

		$opt = get_option ("ipros24-google-translate-options-wordpress");
		if (isset ($opt["translate-admin-panel"]) && $opt["translate-admin-panel"] && $pagenow == "profile.php")
			$languages = array ();

		return $languages;
	}

	function quicktags_settings ($qtInit, $editor_id)	{

//		iPROS24_Utils::log (" buttons = ".$qtInit["buttons"]);

		$opt = get_option ("ipros24-google-translate-options-wordpress");
		if (isset ($opt["quicktags-fix"]) && $opt["quicktags-fix"] && preg_match (self::MATCH, isset ($_COOKIE["googtrans"]) ? $_COOKIE["googtrans"] : "", $match) && $match[1] != $match[2])
			$qtInit["buttons"] = preg_replace ("/^strong,em,/", '', $qtInit["buttons"]);

		return $qtInit;
	}

	function ipros24_google_translate ($atts, $content, $tag)	{

		$atts = shortcode_atts (array ("show-language-codes" => 0, "attribution" => "color"), $atts, $tag);

		$opt = get_option ("ipros24-google-translate-options");
		if ($opt["layout"] == "flags")
			return self::widget ($atts);
		else
			return "<div id='google_translate_element'></div>";
	}
}

if ( !function_exists ("wp_get_current_user")) :

	function wp_get_current_user ()	{

		$user = _wp_get_current_user ();

		$opt = get_option ("ipros24-google-translate-options-wordpress");
		if (isset ($opt["translate-admin-panel"]) && $opt["translate-admin-panel"] || !is_admin ())
			$user->locale = "";

		return $user;
	}

endif;

new iPROS24_google_translate_plugin;

//iPROS24_Utils::$log_level = iPROS24_Utils::LOG_DEBUG;
//iPROS24_Utils::$log_level = iPROS24_Utils::LOG_TRACE;

