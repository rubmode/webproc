		</section>
		<script>
			var base_url = '<?php echo base_url(); ?>'
			var api_url = '<?php echo $this->config->item("api_url"); ?>'
		</script>
		<?php
			foreach ($script as $key => $value) {
				echo '<script src="'.base_url().'assets/'.$value.'.js" type="text/javascript"></script>';
			}
		?>
	</body>
</html>