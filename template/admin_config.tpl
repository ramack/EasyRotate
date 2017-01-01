{combine_css path=$EASYROTATE_PATH|@cat:"template/admin_style.css"}

{footer_script}

jQuery(".showInfo").tipTip({
  delay: 0,
  fadeIn: 200,
  fadeOut: 200,
  maxWidth: '300px',
  defaultPosition: 'bottom'
});
{/footer_script}


<div class="titrePage">
	<h2>EasyRotate</h2>
</div>

<form method="post" action="" class="properties">
<fieldset>
  <legend>{'Settings'|translate}</legend>

  <ul>
    <li>
      <label>
        <input type="checkbox" name="rotate_hd" value="1"{if $easyrotate.rotate_hd} checked="checked"{/if}>
        <b>{'Rotate HD Images'|translate}</b>
      </label>
    </li>
  </ul>
</fieldset>

<p class="formButtons"><input type="submit" name="save_config" value="{'Save Settings'|translate}"></p>

</form>