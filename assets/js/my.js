
(function (ipros24_google_translate, $)	{

	"use strict";

	var TIMEOUT = 1000;

	var old_lang, val, timeout;

	function is_rtl (lang)	{

		return new RegExp ("^" + ipros24_google_translate.RTL.join ("|") + "$", "i").test (lang);
	}

	function check ()	{

		var lang, url, tmp, v;

		tmp = ipros24_utils.get_cookie ("googtrans").match (new RegExp ("/(.*)/(.*)"));
		lang = tmp ? tmp[2] : "";

//		ipros24_utils.log ("check: old_lang = " + old_lang + ", lang = " + lang);

		if (ipros24_google_translate.RELOAD_PAGE && !new RegExp ("^" + (lang ? lang : ipros24_google_translate.SITE_LANGUAGE), "i").test (old_lang))	{

			url = window.location.href;
			url = ipros24_utils.add_arg (url, "lang", lang);

			ipros24_utils.load_safe (url);

			return;
		}

		if (!lang && ipros24_google_translate.MULTILANGUAGE)
			$ ("a.active-language").removeClass ("active-language");

		v = $ ("#ipros24-google-translate-test").text ();
		if (v != val)	{

			val = v;
			ipros24_utils.trigger ("ipros24-translated");
		}

		timeout = setTimeout (check, TIMEOUT);
	}

	$ (document).ready (function ()	{

		wp.hooks.addAction ("ipros24-load", "ipros24-google-translate", function ()	{

//			$ ("div#ed_toolbar").addClass ("notranslate");
			$ (".mejs-controls").addClass ("notranslate");

			ipros24_utils.load_script ("//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit");

			old_lang = $ ("html").attr ("lang");
			val = $ ("#ipros24-google-translate-test").text ();

			timeout = setTimeout (check, TIMEOUT);
		});

		wp.hooks.addAction ("ipros24-unload", "ipros24-google-translate", function ()	{

			clearTimeout (timeout);
		});
	});

	$ (window).on ("ipros24-translated", function ()	{

		ipros24_utils.trigger ("resize");
	});

//	window.onerror = function (msg, url, line)	{
//
////		alert ("onerror: msg = " + msg + " url = " + url + " line = " + line);
//		return true;
//	};

}) (window.ipros24_google_translate = window.ipros24_google_translate || {}, jQuery);

