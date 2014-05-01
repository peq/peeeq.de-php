<?php

require_once 'blog/wp-content/plugins/markdown-on-save/markdown-extra/markdown-extra.php';

class SmartTextProcessor {
	var $language_id = 10;
	var $style_id = 1;
	
	var $language_name= "Text";
	
	var $code = "blub";
	var $output = "<p>blub</p>";
	var $code_css = '<script type="text/javascript"
   src="http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML">
</script>'; //<script type="text/javascript" src="ASCIIMathML.js"></script>';
	
	var $language = false;
	var $format_script = false;

	function __construct($text) {

		$this->code = $text;
		$out = $text;
		//$out = $this->addLineBreaks($out);
		//$out = str_replace("*", "MULT$uid", $out);
		//$out = str_replace("`", "BACKQUOTE$uid", $out);
		preg_match_all('/\$\$(.|\n|\r)*\$\$/mU', $out, $matches);
		$replacements = array();
		//print_r($matches);
		foreach ($matches[0] as $match) {
			$uid = uniqid("temp",true);
			$replacements[$uid] = $match;
			$out = str_replace($match, $uid, $out);
		}
		$out = str_replace("&gt;", ">", $out);
		$out = Markdown($out);
		//$out = str_replace("BACKQUOTE$uid", "`", $out);
		//$out = str_replace("MULT$uid", "*", $out);
		//$out = nl2br($out);
		//$out = str_replace("²", "^2", $out);
		foreach ($replacements as $key => $val) {
			$out = str_replace($key, $val, $out);
		}
		$this->output = '<div class="math-type-block" style="
			width:940px; margin:0 auto; padding: 20px;
			font-size: 18px; color:#333;
			">
			'.$out.'</div>';

	}
	function addLineBreaks($out) {
		$lines = preg_split('/\n|\r|\n\r|\r\n/', $out);
		$result = "";
		$paragraph = "";
		foreach ($lines as $line) {
			$line = trim($line);
			if (strlen($line) == 0) {
				if ($paragraph == "open") {
					$result.="</p>";
				} elseif ($paragraph != "opening") {
					$result.="<p>";
					$paragraph = "opening";
				}
			} elseif ($paragraph == "opening") {
				$paragraph = "open";
			}
			$result .=$line;
		}
		return $result;
	}

}
