<?php

// We need a function that can add ids to HTML header tags
function retitle($match) {
    list($_unused, $h3, $title) = $match;

    $id = strtolower(strtr($title, " .", "--"));

    return "<$h3 id='$id'>$title</$h3>";
}

$html = file_get_contents(dirname(__FILE__) . '/help/readme.html');
?>

<script>
    jQuery(document).ready(function() {
        jQuery(".insert-code").click(function() {
            var example = jQuery( this ).parent().prev().find("code").text();
            var lines = example.split('\n');
            var paras = '';
            jQuery.each(lines, function(i, line) {
                if (line) {
                    paras += line + '<br>';
                }
            });
            var win = window.dialogArguments || opener || parent || top;
            win.send_to_editor(paras);
        });
    
        jQuery('#bootstrap-shortcodes-help h2').each(function(){
            var id = jQuery(this).attr("id");
            jQuery(this).removeAttr("id").nextUntil("h2").andSelf().wrapAll('<div class="tab-pane" id="' + id + '" />');
        });
        jQuery('#supported-shortcodes').addClass('active');
        
    });
</script>

<script type="text/javascript">
  jQuery(document).ready(ajustamodal);
  jQuery(window).resize(ajustamodal);
  function ajustamodal() {
    var altura = jQuery(window).height() - 155; //value corresponding to the modal heading + footer
    jQuery(".ativa-scroll").css({"height":altura,"overflow-y":"auto"});
  }
</script>

<div id="bootstrap-shortcodes-help" class="modal fade">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4>Bootstrap Shortcodes Help</h4>  
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#supported-shortcodes" data-toggle="tab">Supported Shortcodes</a></li>
                    <li><a href="#requirements" data-toggle="tab">System Requirements</a></li>
                </ul>   
        </div>
      <div class="modal-body ativa-scroll">
            <div>

            <div id="bs-top" class="tab-content">
            <?php
                # Put HTML content in the document
                $html = preg_replace('/(<a href="http:[^"]+")>/is','\\1 target="_blank">',$html);
                $html = str_replace('<table>', '<table class="table table-striped">', $html);
                $html = str_replace('<ul>', '<div class="list-group">', $html);
                $html = str_replace('</ul>', '</div>', $html);
                $html = str_replace('<li><a ', '<a class="list-group-item" ', $html);
                $html = str_replace('</li>', '', $html);
                $html = str_replace('<hr>', '<hr><a class="btn btn-link btn-default pull-right" href="#bs-top"><i class="text-muted glyphicon glyphicon-arrow-up"></i></a>', $html);
                $html = preg_replace_callback("#<(h[1-6])>(.*?)</\\1>#", "retitle", $html);
                $html = str_replace('</pre>', '</pre><p><button data-dismiss="modal" class="btn btn-primary btn-sm insert-code">Insert Example <i class="glyphicon glyphicon-share-alt"></i></button></p>', $html);
                echo $html;
            ?>
            </div>
            </div>
        </div>

    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
