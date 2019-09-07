{strip}
{combine_css id="easyrotate" path=$EASYROTATE_PATH|cat:"template/style.css"}
{combine_script id="easyrotate.scripts" load="async" path=$EASYROTATE_PATH|cat:"js/easyrotate.js"}

{footer_script require='easyrotate.scripts'}{literal}
$(document).ready(function() {
    easyrotate_pwg_token = {/literal}'{$EASYROTATE_PWG_TOKEN}'{literal};
    easyrotate_rotate_hd = {/literal}'{$EASYROTATE_ROTATE_HD}'{literal};
    easyrotate_id        = {/literal}'{$EASYROTATE_IMAGE_ID}'{literal};
    easyrotate_path      = {/literal}'{$EASYROTATE_PATH}'{literal};
});
{/literal}{/footer_script}

{if ROTATE_BOOTSTRAP == 1}
  <li class="nav-item">
      <a href="javascript:void(0)" onclick="onEasyRotateClicked(90)" title="{'Rotate counterclockwise'|translate}" class="pwg-state-default pwg-button nav-link" rel="nofollow">
        <i class="fas fa-undo fa-fw" aria-hidden="true"></i>
        <span class="pwg-button-text">{'EasyRotate'|translate}</span>
      </a>
  </li>
  <li class="nav-item">
      <a href="javascript:void(0)" onclick="onEasyRotateClicked(270)" title="{'Rotate clockwise'|translate}" class="pwg-state-default pwg-button nav-link" rel="nofollow">
        <i class="fas fa-redo fa-fw" aria-hidden="true"></i>
        <span class="pwg-button-text">{'EasyRotate'|translate}</span>
      </a>
  </li>
{elseif ROTATE_BOOTSTRAP == 0}
  <a href="javascript:void(0)" onclick="onEasyRotateClicked(90)" title="{'Rotate counterclockwise'|translate}" class="pwg-state-default pwg-button" rel="nofollow">
    <span class="pwg-icon easyrotate-ccw-button"> </span>
    <span class="pwg-button-text">{'EasyRotate'|translate}</span>
  </a>
  <a href="javascript:void(0)" onclick="onEasyRotateClicked(270)" title="{'Rotate clockwise'|translate}" class="pwg-state-default pwg-button" rel="nofollow">
    <span class="pwg-icon easyrotate-cw-button"> </span>
    <span class="pwg-button-text">{'EasyRotate'|translate}</span>
  </a>
{/if}

{/strip}
