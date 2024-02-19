<?php

if (! function_exists('lotus'))
{
	/**
	 * @return \EMedia\Lotus\Base\LotusHtml
	 */
	function lotus()
	{
		return app(\EMedia\Lotus\Base\LotusHtml::class);
	}

}
