var easyrotate_pwg_token;
var easyrotate_rotate_hd;
var easyrotate_id;

function onEasyRotateClicked(angle) {
    (new PwgWS("")).callService("pwg.image.rotate",
                                { image_id: easyrotate_id,
                                  angle: angle,
                                  pwg_token: easyrotate_pwg_token,
                                  rotate_hd: easyrotate_rotate_hd
                                },
                                { method: "POST",
                                  onFailure: function(num, text) {
                                             },
                                  onSuccess: function(result) {
                                                 location.reload();
                                             }
                                }
                              );
    return false;
}
