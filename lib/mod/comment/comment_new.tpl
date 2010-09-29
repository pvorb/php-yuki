<div class="comment new">
	<div class="content">
<?php echo $comment_message; ?>
	</div>
	<div class="meta">
		Comment by <?php if ($comment_website) echo '<a href="'.$comment_website.'">'.$comment_name.'</a>'; ?> on <?php echo $comment_date; ?> at <?php echo $comment_time; ?>.
	</div>

	<p><strong>Your comment has been saved.</strong></p>
</div>
