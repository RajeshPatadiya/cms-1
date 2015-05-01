<?php namespace Devise\Languages;

use Request, Cookie, Config;

/**
 * Locales are shorthand 2 letter strings
 * for a language/region.
 */
class LocaleDetector
{
	/**
	 * The cookie we store the locale under
	 *
	 * @var string
	 */
	protected $cookieKey = 'devise.my.locale';

	/**
	 * Get the current locale. At first we try
	 * to use the cookie if one is set. If a cookie
	 * is not set then we attempt to deduce the locale
	 * in this order: url segment, http headers, and finally
	 * we fall back to the universal locale which is
	 * set in laravel's app.locale (defaults to en).
	 *
	 * @return string
	 */
	public function current()
	{
		$locale = $this->cookie();

		if (!$locale)
		{
			$locale = $locale ?: $this->segment();
			$locale = $locale ?: $this->header();
			$locale = $locale ?: $this->universal();
			$this->update($locale);
		}

		return $locale;
	}

	/**
	 * Get the locale from a cookie
	 *
	 * @return string
	 */
	public function cookie()
	{
		return Cookie::get($this->cookieKey, null);
	}

	/**
	 * Get the universal locale set by developer and laravel
	 *
	 * @return string
	 */
	public function universal()
	{
		return Config::get('app.locale');
	}

	/**
	 * Get locale from header accept string
	 *
	 * @return string
	 */
	public function header()
	{
		return substr(Request::server('HTTP_ACCEPT_LANGUAGE', null), 0, 2);
	}

	/**
	 * We don't use this, but we could use it later
	 * if we wanted to. It would get the locale
	 * from the first segment of the url, e.g.
	 *
	 * 	http://somesite.com/en/cool/page
	 *
	 * @return string
	 */
   	public function segment()
    {
        return Request::segment(1, null);
    }

	/**
	 * Updates the locale stored in this cookie
	 *
	 * @param  string $locale
	 * @return string
	 */
	public function update($locale)
	{
		Cookie::forever($this->cookieKey, $locale);
	}
}