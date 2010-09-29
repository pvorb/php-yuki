<!-- example comment form -->
<form action="" method="post">
	<h3>Leave a comment</h3>
	<label for="comment-form-message">Message</label><br />
	<textarea name="comment-message" rows="10" cols="30" id="comment-form-message"><?php echo $comment_message; ?></textarea><br />
	<input name="comment-name" value="<?php echo $comment_name; ?>" type="text" size="25" id="comment-form-name" />
	<label for="comment-form-name">Name</label><br />
	<input name="comment-website" value="<?php echo $comment_website; ?>" type="text" size="25" id="comment-form-website" />
	<label for="comment-form-website">Website</label><br />
	<input name="comment-new" type="submit" value="Comment" /> <input name="comment-preview" type="submit" value="Preview" />
</form>
