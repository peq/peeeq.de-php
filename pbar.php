<?
require_once("session.php");

function pbar_create_link($link, $caption, $site)
{
	if ($site != $link)
	{
		return '<a class="pbar" href="'.$link.'">'.$caption.'</a>';
	}
	else
	{
		return '<font class="pbar">'.$caption.'</font>';
	}
}

function pbar_print($site = "")
{
$result = "";
$result.='
<div style="
background-color:#F0F0FF;
color:#9090C0;
border-left:0px;border-right:0px;border-top:0px;border-bottom:1px;border-style:solid;
width:100%;height:24px;
padding: 0 0 0 0;
margin: 0 0 0 0;
">
<table width=100%>
	<tr>
		<td align="left">
			<nobr>
				';
				$result.= pbar_create_link("index.php", "Home", $site);
				$result.= pbar_create_link("gui.php", "GUI", $site);
				$result.= pbar_create_link("jass.php", "Jass", $site);
				$result.= pbar_create_link("java.php", "Java", $site);
				$result.= pbar_create_link("delphi.php", "Delphi", $site);
				$result.= pbar_create_link("upload.php", "Upload", $site);
				$result.= pbar_create_link("text.php", "Text", $site);
				$result.= pbar_create_link("html.php", "HTML", $site);
				/*	<a class="pbar" href="gui.php">GUI</a>
					<a class="pbar" href="jass.php">Jass</a>
					<a class="pbar" href="java.php">Java</a>
					<a class="pbar" href="delphi.php">Delphi</a>
					<a class="pbar" href="upload.php">Upload</a>
					<a class="pbar" href="text.php">Text</a>
					<a class="pbar" href="html.php">HTML</a>
				*/
				$result.='
			</nobr>
		</td>
		<td align="right">';
			if (session_is_logged_in())
			{
				$result.='angemeldet als '.session_get_username();
			}
			else
			{
				//$result.='<a href="login.php">Anmelden</a>';
				$result.= pbar_create_link("login.php", "Anmelden", $site);
			}		
$result.='
		</td>
	</tr>
</table>
</div>

';
return $result;
}
?>