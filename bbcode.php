<?
require_once 'stringparser_bbcode.class.php';

$bbcode = null;


// Unify line breaks of different operating systems
function convertlinebreaks ($text) {
    return preg_replace ("/\015\012|\015|\012/", "\n", $text);
}

// Remove everything but the newline charachter
function bbcode_stripcontents ($text) {
    return preg_replace ("/[^\n]/", '', $text);
}

function do_bbcode_url ($action, $attributes, $content, $params, $node_object) {
    if (!isset ($attributes['default'])) {
        $url = $content;
        $text = htmlspecialchars ($content);
    } else {
        $url = $attributes['default'];
        $text = $content;
    }
    if ($action == 'validate') {
        if (substr ($url, 0, 5) == 'data:' || substr ($url, 0, 5) == 'file:'
          || substr ($url, 0, 11) == 'javascript:' || substr ($url, 0, 4) == 'jar:') {
            return false;
        }
        return true;
    }
    return '<a href="'.htmlspecialchars ($url).'">'.$text.'</a>';
}

// Function to include images
function do_bbcode_img ($action, $attributes, $content, $params, $node_object) {
    if ($action == 'validate') {
        if (substr ($content, 0, 5) == 'data:' || substr ($content, 0, 5) == 'file:'
          || substr ($content, 0, 11) == 'javascript:' || substr ($content, 0, 4) == 'jar:') {
            return false;
        }
        return true;
    }
    return '<img src="'.htmlspecialchars($content).'" alt="" />';
}


function do_bbcode_size ($action, $attributes, $content, $params, $node_object) {
	//print_r($attributes);
    return '<font size="'.intval($attributes['default']).'">'.$content.'</font>';
}

function do_bbcode_color ($action, $attributes, $content, $params, $node_object) {
	//print_r($attributes);
    return '<font color="'.$attributes['default'].'">'.$content.'</font>';
}

function do_bbcode_code ($action, $attributes, $content, $params, $node_object) {
	//print_r($attributes);
    return '<code class="codeStyle">'.trim($content).'</code>';
}

$id = 0;
function do_bbcode_swap ($action, $attributes, $content, $params, $node_object) {
	//print_r($attributes);
	$title = "mehr...";
	if (isset($attributes['default']))
	{
		$title = $attributes['default'];
	}
	global $id;
	$id++;
    return '
	<a href="#" onclick=\'
	var e = document.getElementById("swaptext'.$id.'");
	if (e.style.display == "block") {
		e.style.display = "none";
	} else {
		e.style.display = "block";
	}
	return false;
	\'>'.$title.'</a>
	<div id="swaptext'.$id.'" class="bbcode_swap" style="display:none;">'.$content.'</div>';
}

function do_bbcode_list ($action, $attributes, $content, $params, $node_object) {
	//print_r($attributes);
	if (isset($attributes['default']))
	{
		if ($attributes['default'] == "1")
		{
			return '<ol>'.$content.'</ol>';
		}
		elseif ($attributes['default'] == "a")
		{
			return '<ol type="a">'.$content.'</ol>';
		}
	}		
	return '<ul>'.$content.'</ul>';
	   
}

function bbcode_init()
{
	global $bbcode;
	$bbcode = new StringParser_BBCode ();
	$bbcode->addFilter (STRINGPARSER_FILTER_PRE, 'convertlinebreaks');

	$bbcode->addParser (array ('block', 'inline', 'link', 'listitem'), 'htmlspecialchars');
	$bbcode->addParser (array ('block', 'inline', 'link', 'listitem'), 'nl2br');
	$bbcode->addParser ('list', 'bbcode_stripcontents');
	
	//[b]
	$bbcode->addCode ('b', 'simple_replace', null, array ('start_tag' => '<b>', 'end_tag' => '</b>'),
	                  'inline', array ('listitem', 'block', 'inline', 'link'), array ());
	//[i]
	$bbcode->addCode ('i', 'simple_replace', null, array ('start_tag' => '<i>', 'end_tag' => '</i>'),
	                  'inline', array ('listitem', 'block', 'inline', 'link'), array ());
    //[u]
	$bbcode->addCode ('u', 'simple_replace', null, array ('start_tag' => '<u>', 'end_tag' => '</u>'),
	                  'inline', array ('listitem', 'block', 'inline', 'link'), array ());
	//[s]
	$bbcode->addCode ('s', 'simple_replace', null, array ('start_tag' => '<s>', 'end_tag' => '</s>'),
	                  'inline', array ('listitem', 'block', 'inline', 'link'), array ());
	//[code]
	$bbcode->addCode ('code', 'callback_replace', 'do_bbcode_code', array ('usecontent_param' => 'default'),
	                  'code', array ('listitem', 'block', 'inline', 'link'), array ());	
	//[quote]
	$bbcode->addCode ('quote', 'simple_replace', null, array ('start_tag' => '<blockquote class="bbcode_quote">', 'end_tag' => '</blockquote>'),
	                  'inline', array ('listitem', 'block', 'inline', 'link'), array ());	
	//[q]
	$bbcode->addCode ('q', 'simple_replace', null, array ('start_tag' => '<q>', 'end_tag' => '</q>'),
	                  'inline', array ('listitem', 'block', 'inline', 'link'), array ());	
	//[swap]
	$bbcode->addCode ('swap', 'callback_replace', 'do_bbcode_swap', array ('usecontent_param' => 'default'),
	                  'block', array ('listitem', 'block', 'inline', 'link'), array ());	
	//[url]
	$bbcode->addCode ('url', 'usecontent?', 'do_bbcode_url', array ('usecontent_param' => 'default'),
	                  'link', array ('listitem', 'block', 'inline'), array ('link'));
	//[size]
	$bbcode->addCode ('size', 'usecontent?', 'do_bbcode_size', array ('usecontent_param' => 'default'),
	                  'inline', array ('listitem', 'block', 'inline'), array ());
	//[color]
	$bbcode->addCode ('color', 'usecontent?', 'do_bbcode_color', array ('usecontent_param' => 'default'),
	                  'inline', array ('listitem', 'block', 'inline'), array ());
	//[url
	$bbcode->addCode ('link', 'callback_replace_single', 'do_bbcode_url', array (),
	                  'link', array ('listitem', 'block', 'inline'), array ('link'));
	//[img]
	$bbcode->addCode ('img', 'usecontent', 'do_bbcode_img', array (),
	                  'image', array ('listitem', 'block', 'inline', 'link'), array ());
	//[img]
	$bbcode->addCode ('bild', 'usecontent', 'do_bbcode_img', array (),
	                  'image', array ('listitem', 'block', 'inline', 'link'), array ());
	$bbcode->setOccurrenceType ('img', 'image');
	$bbcode->setOccurrenceType ('bild', 'image');
	$bbcode->setMaxOccurrences ('image', 2);
	//[list]
	/*$bbcode->addCode ('list', 'simple_replace', null, array ('start_tag' => '<ul>', 'end_tag' => '</ul>'),
	                  'list', array ('block', 'listitem'), array ());*/
	$bbcode->addCode ('list', 'callback_replace', 'do_bbcode_list', array ('usecontent_param' => 'default'),
	                  'list', array ('listitem', 'block', 'inline'), array ());
	$bbcode->addCode ('*', 'simple_replace', null, array ('start_tag' => '<li>', 'end_tag' => '</li>'),
	                  'listitem', array ('list'), array ());
	$bbcode->setCodeFlag ('*', 'closetag', BBCODE_CLOSETAG_OPTIONAL);
	$bbcode->setCodeFlag ('*', 'paragraphs', true);
	$bbcode->setCodeFlag ('list', 'paragraph_type', BBCODE_PARAGRAPH_BLOCK_ELEMENT);
	$bbcode->setCodeFlag ('list', 'opentag.before.newline', BBCODE_NEWLINE_DROP);
	$bbcode->setCodeFlag ('list', 'closetag.before.newline', BBCODE_NEWLINE_DROP);
	
	$bbcode->setRootParagraphHandling (false);

}

function bbcode_parse($text)
{
	global $bbcode;
	if ($bbcode == null)
	{
		bbcode_init();
	}
	
	$result = $bbcode->parse ($text);
	$result = str_replace("","  ",$result);
	$result = str_replace("  "," &nbsp;",$result);
	
	//deutsche Sonderzeichen:
	$result = str_replace("Ã¤","&auml;",$result);
	$result = str_replace("Ã¶","&ouml;",$result);
	$result = str_replace("Ã¼","&uuml;",$result);

	$result = str_replace("Ã&amp;#8222;","&Auml;",$result);
	$result = str_replace("Ã&amp;#8211;","&Ouml;",$result);
	$result = str_replace("Ã&amp;#339;","&Uuml;",$result);
	$result = str_replace("Ã&amp;#376;","&szlig;",$result);
	
	$result = str_replace("Ã„","&Auml;",$result);
	$result = str_replace("Ã–","&Ouml;",$result);
	$result = str_replace("Ãœ","&Uuml;",$result);
	$result = str_replace("ÃŸ","&szlig;",$result);
	
	//auto-links
	$result = preg_replace('/([[:space:]]|^|>|;)(http\:\/\/([[:alnum:]]|[[:punct:]])*?)([[:space:]]|<|$)/', '$1<a href="$2">$2</a>$4', $result); 
	
	return $result;
}

?>