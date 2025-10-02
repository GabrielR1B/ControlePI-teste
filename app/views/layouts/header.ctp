<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="pt-br">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $title_for_layout; ?>
	</title>
	<?php

		echo $this->Html->meta('icon');
		echo $this->Html->css('token-input');
		echo $this->Html->css('reset.css');
		echo $this->Html->css('ui-lightness/jquery-ui-1.8.11.custom.css');
		echo $this->Html->css('estilo.css');
		echo $this->Html->script('jquery-1.6.2.min.js');
		echo $this->Html->script('jquery-ui-1.8.11.custom.min.js');
		echo $this->Html->script('jquery.form.js');
		echo $this->Html->script('textext 1.3.js');
		echo $this->Html->script('jquery.tokeninput.js');
		echo $this->Html->script('jquery.maskedinput.min.js');
		echo $this->Html->script('jquery.dataTables.nightly.js');
		echo $scripts_for_layout;

	?>

	<script type="text/javascript">
	  var base_url = "<?php echo BASE_URL ?>"
	</script>