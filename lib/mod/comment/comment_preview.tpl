<div class="preview">
<?php if ($this->errors): ?>
	<h3>Your comment is invalid.</h3>
	<ol>
<?php
	foreach ($this->errors as $error) {
		echo '<li><a href="#comment-form-'.$error.'">';
		switch ($error) {
			case 'message':
				echo 'The message must not be empty.';
			break;
			case 'name':
				echo 'You must enter a name.';
			break;
			case 'website':
				echo 'The website you entered was invalid. You may also leave this field empty.';
			break;
			case 'email':
				echo 'You must enter a valid e-mail address.';
			break;
		}
		echo '</a></li>'.ENDL;
	}
?>
	</ol>
<?php endif; ?>
	<h3>Preview</h3>
	<div class="content">
<?php echo $this->message; ?>
	</div>
	<div class="meta">
		Comment by <?php
if ($this->website)
	echo '<a href="'.$this->website.'">'.$this->name.'</a>';
else
	echo $this->name;
?> on <?php echo $this->date; ?> at <?php echo $this->time; ?>.
	</div>
</div>
