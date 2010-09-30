<div class="preview">
	<div class="content">
<?php echo $this->message; ?>
	</div>
	<div class="meta">
		Comment by <?php if ($this->website) echo '<a href="'.$this->website.'">'.$this->name.'</a>'; ?> on <?php echo $this->date; ?> at <?php echo $this->time; ?>.
	</div>
</div>
