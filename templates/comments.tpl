<div>
	<div id="comments_form">
	{if $draw_comments_form}
		
			
		<form id="addcommentform" action="index.php" method="post"> 
			<h1>Kommentar schreiben:</h1>
			<fieldset>
				<legend>Kommentar schreiben:</legend>
				{if $session_is_logged_in == false}<label id="labelforusername" for="username" class="label">Name:</label><input type="text" name="username" id="username" accesskey="n" value="Gast" /><br />{/if}
				<label id="labelfortext" for="text" class="label">Text:</label>
				<textarea cols="35" rows="5" name="text" id="text" accesskey="t">
		</textarea><br />
				
				<input type="checkbox" name="wysiwyg" id="wysiwyg" value="1"/> 			   <label id="labelforwysiwyg" for="wysiwyg" class="label"><a href="http://tinymce.moxiecode.com?id=powered_by_tinymce_mini"><img src="tinymce_button.png" border="0" width="80" height="15" alt="Powered by TinyMCE" /></a>-Editor anschalten.</label>
				<br />
				{if $session_is_logged_in == false}
				<img src="captcha.php" alt="captcha" width="81" height="34" /> <label id="labelforcaptcha" for="captcha" class="label">Buchstaben-Code:</label><input type="text" name="captcha" id="captcha" accesskey="c" value="" />
				{/if}
				<span><input type="submit" value="Kommentar posten" id="submit" name="submit" accesskey="k" /></span>
				<input type="hidden" id="method" name="method" value="html" />
				<input type="hidden" id="ajax" name="ajax" value="addcomments" />
				<input type="hidden" id="topic" name="topic" value="0" />
				<input type="hidden" id="from" name="from" value="0" />
				<input type="hidden" id="count" name="count" value="10" />
			</fieldset>
		</form>
	{/if}
	</div>
	<div id="comments_comments">
	{foreach from=$comments item=comment}
		<div class="comment">
			{if $comment.spam < 10}
				<div class="commenthead">
					
					
					<strong>{$comment.username}</strong> (vor {$comment.ago_time})
					{if $admin}
					<form action="index.php" method="post" class="markspam">
						<input type="hidden" name="id" value="{$comment.id}">
						<input type="hidden" name="action" value="markspam">
						<input type="submit" value="als Spam markieren">
					</form>
					{/if}
				</div>
				<div class="commenttext">
				{$comment.parsed_text}
				</div>
			{else}
				{if $admin}
					Als Spam markierter Kommentar. (<a href="">zeigen</a>)
				{/if}
			{/if}
		</div>
	{/foreach}
	Seite: 
	<ul id="comments_pages">
	{foreach from=$comment_pages item=comment_page}
		{if $comment_page.current}
			<li>{$comment_page.i}</li>
		{else}
			<li><a onclick='return change_page({$comment_page.from}, {$comment_page.count});' href="index.php?from={$comment_page.from}&amp;count={$comment_page.count}">{$comment_page.i}</a></li>
		{/if}
	{/foreach}
	</ul>
	</div>
</div>