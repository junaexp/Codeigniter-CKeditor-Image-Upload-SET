<?php echo form_open_multipart('[YOUR PATH]', array('autocomplete'=>"off"));?>
<section style="padding: 5px;">
	<div>
		<label>본문</label>
		<textarea id="ckeditor" required></textarea>
	</div>


	<div>
		<button type="submit">submit</button>
	</div>
</section>
<?php echo form_close();?>

<?php
    ############################################################################################################
    ## CK
    ############################################################################################################
?>
<script src="<?=base_url();?>assets/dist/ckeditor/ckeditor.js"></script>

<script>
    CKEDITOR.replace( 'ckeditor', {
        extraPlugins : 'image2,codesnippet,uploadimage',

        codeSnippet_theme: 'monokai_sublime',
        height: 300,
        enterMode: CKEDITOR.ENTER_BR,
        filebrowserImageUploadUrl : '<?=base_url();?>[Ck_upload PATH]/?type=image&path=work'
    });
</script>
