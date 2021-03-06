<?php 


function appendSessionBodyTail() {
	ob_start();
?>
<script type="text/javascript" src="<?php echo STATIC_URL; ?>js/processing-1.4.1.min.js"></script>
<script type="text/javascript" src="<?php echo STATIC_URL; ?>js/ace/ace.js"></script>
<script type="text/javascript" charset="utf-8">
	$(document).ready(function() {
		
		$('.session-content section').each(function() {
			var $section = $(this);
			if ($section.attr('id') && $section.find('h1').length) {
				$('#sidebar-nav').append('\
					<li><a href="#' + $(this).attr('id') + '">' + $(this).find('h1').html() + '</a></li>\
				');
			}
		});
		
		$('body').scrollspy();
		$('.answer-container').click(function() {
			$(this).toggleClass('revealed').children().slideToggle();
		});
		
		// cause bootstrap's affix kinda sucks
		var sidebarOrigin = $('#sidebar-nav').offset().top;
		$(window).scroll(function() {
			var $window = $(window);
			if ($window.scrollTop() > sidebarOrigin - 80) {
				$('#sidebar-nav').addClass('affixed');
			}
			else {
				$('#sidebar-nav').removeClass('affixed');
			}
		});
		
		$('.pretty-code').each(function() {
			var $input = $(this);
			var inputId = $input.attr('id');
			var editor = ace.edit(inputId);
			editor.setTheme("ace/theme/xcode");
			var lang = $(this).data('language') || 'javascript';
			editor.getSession().setMode("ace/mode/" + lang);
			$input.data('editor', editor);
			if ($(this).hasClass('non-editable')) {
				editor.setReadOnly(true);
			}
		});
		
		$('.line-highlighter').each(function() {
			$(this).on('click', function() {
				var $target = $('#' + $(this).data('target'));
				if ($target.length) {
					var editor = $target.data('editor');
					editor.gotoLine($(this).data('line'));
				}
				return false;
			});
		});
		
		$('.php-run').on('click', function() {
			var $codeContainer = $(this).parents('.live-example').find('.pretty-code');
			var $resultContainer = $(this).parents('.live-example').find('iframe')
			var editor = $codeContainer.data('editor');
			if (editor) {
				var code = '?>' + editor.getValue();
				ipw.evalPHP(code, function(result) {
					$resultContainer.get(0).contentWindow.document.documentElement.innerHTML = result;
				}, function(textStatus, error) {
					console.log(textStatus, error);
				});
				
			}
		});
	});
</script>


<script type="text/javascript" src="<?php echo STATIC_URL; ?>js/romano/dependencies/raphael-1.3.2.js"></script>
<script type="text/javascript" src="<?php echo STATIC_URL; ?>js/romano/classes/Romano.js"></script>
<script type="text/javascript" src="<?php echo STATIC_URL; ?>js/romano/classes/Sprite.js"></script>
<script type="text/javascript" src="<?php echo STATIC_URL; ?>js/romano/classes/Surface.js"></script>
<script type="text/javascript" src="<?php echo STATIC_URL; ?>js/romano/classes/Renderer.js"></script>
<script type="text/javascript" src="<?php echo STATIC_URL; ?>js/romano/classes/RaphaelSurface.js"></script>
<script type="text/javascript" src="<?php echo STATIC_URL; ?>js/romano/classes/RaphaelRenderer.js"></script>
<script type="text/javascript" src="<?php echo STATIC_URL; ?>js/romano/classes/Viewport.js"></script>

<script type="text/javascript" charset="utf-8" src="<?php echo STATIC_URL; ?>js/karel/karel.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo STATIC_URL; ?>js/karel/classes/Karel.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo STATIC_URL; ?>js/karel/classes/Cheese.js"></script>

<script type="text/javascript" src="<?php echo STATIC_URL; ?>js/app.js"></script>

<?php
	app()->appendTo('HTMLBodyTail', ob_get_clean());
}

?>