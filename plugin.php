<?php

class pluginYandexTools extends Plugin {

	public function init()
	{
		$this->dbFields = array(
			'yametrika-id'=>'',
			'yandex-verification'=>''
		);
	}

	public function form()
	{
		global $Language;

		$html  = '<div>';
		$html .= '<label>'.$Language->get('Yandex.Webmaster').'</label>';
		$html .= '<input type="text" name="yandex-verification" value="'.$this->getDbField('yandex-verification').'">';
		$html .= '<span class="tip">'.$Language->get('complete-this-field-with-the-yandex-verification').'</span>';
		$html .= '</div>';

		$html .= '<div>';
		$html .= '<label>'.$Language->get('Yandex.Metrika Counter ID').'</label>';
		$html .= '<input type="text" name="yametrika-id" value="'.$this->getDbField('yametrika-id').'">';
		$html .= '<span class="tip">'.$Language->get('complete-this-field-with-the-yametrika-id').'</span>';
		$html .= '</div>';

		return $html;
	}

	public function siteHead()
	{
                global $Url;

                if( $this->getValue('yandex-verification') && $Url->whereAmI()=='home' ) {
	                $html  = PHP_EOL.'<!-- Yandex.Webmaster ID -->'.PHP_EOL;
        	        $html  .= '<meta name="yandex-verification" content="'.$this->getDbField('yandex-verification').'" />'.PHP_EOL;
                	return $html;
		}
		return false;

	}

	public function siteBodyEnd()
	{
		$html  = PHP_EOL.'<!-- Yandex.Metrika counter -->'.PHP_EOL;
		$html .= "<script type='text/javascript'>
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter".$this->getDbField('yametrika-id')." = new Ya.Metrika({
                    id:".$this->getDbField('yametrika-id').",
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName('script')[0],
            s = d.createElement('script'),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = 'text/javascript';
        s.async = true;
        s.src = 'https://mc.yandex.ru/metrika/watch.js';

        if (w.opera == '[object Opera]') {
            d.addEventListener('DOMContentLoaded', f, false);
        } else { f(); }
    })(document, window, 'yandex_metrika_callbacks');
</script>
<noscript><div><img src='https://mc.yandex.ru/watch/".$this->getDbField('yametrika-id')."' style='position:absolute; left:-9999px;' alt='' /></div></noscript>".PHP_EOL;

		if(Text::isEmpty($this->getDbField('yametrika-id'))) {
			return false;
		}

		return $html;
	}
}
