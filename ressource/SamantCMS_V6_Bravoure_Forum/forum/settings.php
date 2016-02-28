<?php

		function bbcode($text)
		{

			$text = preg_replace('!\[quote\](.+)\[/quote\]!isU', '<div class="citationforum">$1</div>', $text);
			$text = preg_replace("!\[quote\=(.+)\](.+)\[\/quote\]!isU", '<div class="citationforum"><strong>$1 :</strong><br>$2</div>', $text); 
			$text = preg_replace('!\[b\](.+)\[/b\]!isU', '<strong>$1</strong>', $text);
			$text = preg_replace('!\[ul\](.+)\[/ul\]!isU', '<ul>$1</ul>', $text);
			$text = preg_replace('!\[li\](.+)\[/li\]!isU', '<li>$1</li>', $text);

			$text = preg_replace('!\[code\](.+)\[/code\]!isU', '<pre>$1</pre>', $text);


			$text = preg_replace('!\[i\](.+)\[/i\]!isU', '<em>$1</em>', $text);
			$text = preg_replace('!\[u\](.+)\[/u\]!isU', '<span style="text-decoration:underline;">$1</span>', $text);
			$text = preg_replace('!\[center\](.+)\[/center\]!isU', '<p tyle="text-align:center;margin:0px;padding:0px;">$1</p>', $text);
			$text = preg_replace('!\[justify\](.+)\[/justify\]!isU', '<p tyle="text-align:justify;margin:0px;padding:0px;">$1</p>', $text);
			$text = preg_replace('!\[right\](.+)\[/right\]!isU', '<p style="text-align:right;margin:0px;padding:0px;">$1</p>', $text);
			$text = preg_replace('!\[left\](.+)\[/left\]!isU', '<p style="text-align:left;margin:0px;padding:0px;">$1</p>', $text);
			$text = preg_replace('!\[titre\](.+)\[/titre\]!isU', '<h3>$1</h3>',$text);
			$text = preg_replace('!\[email\](.+)\[/email\]!isU', '<a href="mailto:$1">$1</a>',$text);
			$text = preg_replace('!\[img\](.+)\[/img\]!isU', '<img src="$1" border="0">',$text);
			$text = preg_replace('!\[url\](.+)\[/url\]!isU', '<a href="$1" target="_blank">$1</a>',$text);


	        $text = preg_replace('#\[B\](.+)\[/B\]#isU', '<strong>$1</strong>', $text);
	        $text = preg_replace('#\[I\](.+)\[/I\]#isU', '<em>$1</em>', $text);
	        $text = preg_replace('#\[U\](.+)\[/U\]#isU', '<span style="text-decoration: underline">$1</span>', $text);
	        $text = preg_replace('#\[STRIKE\](.+)\[/STRIKE\]#isU', '<strike>$1</strike>', $text);
	                
	        $text = preg_replace('#\[COLOR=(black|darkred|red|orange|brown|yellow|green|olive|cyan|blue|darkblue|indigo|violet|white|)\](.+)\[/COLOR\]#isU', '<span style="color:$1">$2</span>', $text);
	        $text = preg_replace('#\[SIZE=(.+)\](.+)\[/SIZE\]#isU', '<span style="font-size: $1em; line-height: normal">$2</span>', $text);
	        $text = preg_replace('#\[size=(.+)\](.+)\[/size\]#isU', '<span style="font-size: $1em; line-height: normal">$2</span>', $text);
	        $text = preg_replace('#\[FONT=(.+)\](.+)\[/FONT\]#isU', '<font face=$1>$2</font>', $text);
	        $text = preg_replace('#\[font=(.+)\](.+)\[/font\]#isU', '<font face=$1>$2</font>', $text);
	       
	        $text = preg_replace("/\[COLOR=(.*)\](.*)\[\/COLOR\]/isU", "<font color=\"$1\">$2</font>", $text);
	        $text = preg_replace("/\[color=(.*)\](.*)\[\/color\]/isU", "<font color=\"$1\">$2</font>", $text);
	       
	        $text = preg_replace('#\[QUOTE\](.+)\[/QUOTE\]#isU', '<table width="100%" cellspacing="1" cellpadding="3" border="0" align="center"><tr> <td><span class="genmed"><b>Citation:</b></span></td></tr><tr><td class="quote">$1</span></td></tr></table>', $text);
	        $text = preg_replace('#\[SPOILER\](.+)\[/SPOILER\]#isU', '<table style="CURSOR: pointer" onclick="if(this.getElementsByTagName(\'td\')[1].style.display == \'none\'){ this.getElementsByTagName(\'td\')[1].style.display = \'\';this.getElementsByTagName(\'td\')[2].style.display = \'none\'; }else{ this.getElementsByTagName(\'td\')[1].style.display = \'none\';this.getElementsByTagName(\'td\')[2].style.display = \'\';}" cellSpacing=1 cellPadding=3 width="90%" align=center border=0><tbody><tr><td><span class=genmed><b>Spoiler:</b></span></td></tr><tr><td class=quote>&nbsp;</td><td class=quote style="DISPLAY: none">$1</td></tr></tbody></table>', $text);
	        $text = preg_replace('#\[LISTE\](.+)\[/LISTE\]#isU', '<ul>$1</ul>', $text);
	        $text = preg_replace('#\[*\](.+)\[/*\]#isU', '<li>$1</li>', $text);
	                
	        $text = preg_replace('#\[IMG\](.+)\[/IMG\]#isU', '<img src="$1" border="0" />', $text);
	        $text = preg_replace('#\[URL=(.+)\](.+)\[/URL\]#isU', '<a href="$1" target=\"_blank\" class=\"postlink\">$2</a>', $text);
	        $text = preg_replace('#\[URL\](.+)\[/URL\]#isU', '<a href="$1" target=\"_blank\" class=\"postlink\">$1</a>', $text);
	            
	        $text = preg_replace('#\[MOVE\](.+)\[/MOVE\]#isU', '<marquee>$1</marquee>', $text);
	        $text = preg_replace('#\[BLUR\](.+)\[/BLUR\]#isU', '<span style="FILTER: blur(add=1,direction=270,strength=10); HEIGHT: 20px">$1</span>', $text);

	        $text = preg_replace( "#\[youtube\](.+?)\[/youtube\]#is", '<embed src="http://www.youtube.com/v/\\1" type="application/x-shockwave-flash" wmode="transparent" width="512" height="313" allowfullscreen="true" />', $text );	

			return($text);

		}  

		//

		function banniere($level)
		{
			switch ($level) {
			    case 0:
			        $type = 'Membre';
			        $banniere = 'bannerBlueDark';
			        break;

			    case 1:
			        $type = 'Modérateur';
			        $banniere = 'bannerRed';
			        break;

		}

			return '<div class="'.$banniere.'">'.$type.'</div><div class="arrow-1"></div><div class="arrow-2"></div>';
		}

		if(!function_exists('secure')){
			function secure($value){ 
			   return htmlspecialchars($value); 
			} 
		}

		function verifie_texte($texte)
		{
			$texte = htmlentities($texte, ENT_NOQUOTES, 'utf-8');
			
		    if(strlen($texte) < 5) return 'tooshort';
		    elseif(strlen($texte) > 5000) return 'toolong';
		    else return 'ok';
		}

?>
