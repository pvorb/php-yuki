<!-- example comment form -->
<form action="" method="post">
<?php
// Depending on if the user has pressed the commit button or the preview button
// an empty form will be included or not.
if ($this->mode != COMMENT_MODE_LIST): ?>
	<h3>Leave a comment</h3>
	<label for="comment-form-message">Message</label><br />
	<textarea name="comment-message" rows="10" cols="30" id="comment-form-message"<?php if(isset($this->errors['message'])) echo ' class="error"'; ?>><?php echo $_POST['comment-message']; ?></textarea><br />
	<input name="comment-name" value="<?php echo $this->name; ?>" type="text" size="25" id="comment-form-name"<?php if (isset($this->errors['name'])) echo ' class="error"'?> />
	<label for="comment-form-name">Name</label><br />
	<input name="comment-website" value="<?php echo $this->website; ?>" type="text" size="25" id="comment-form-website"<?php if (isset($this->errors['website'])) echo ' class="error"'?> />
	<label for="comment-form-website">Website</label><br />
	<input name="comment-email" value="<?php echo $this->email; ?>" type="text" size="25" id="comment-form-email"<?php if (isset($this->errors['email'])) echo ' class="error"'?> />
	<label for="comment-form-email">E-mail</label><br />
<?php else: ?>
	<h3>Leave a comment</h3>
	<label for="comment-form-message">Message</label><br />
	<textarea name="comment-message" rows="10" cols="30" id="comment-form-message"></textarea><br />
	<input name="comment-name" type="text" size="25" id="comment-form-name" />
	<label for="comment-form-name">Name</label><br />
	<input name="comment-website" type="text" size="25" id="comment-form-website" />
	<label for="comment-form-website">Website</label><br />
	<input name="comment-email" type="text" size="25" id="comment-form-email" />
	<label for="comment-form-email">E-mail</label><br />
<?php endif; ?>
	<input name="comment-save" type="submit" value="Comment" /> <input name="comment-preview" type="submit" value="Preview" />
</form>
