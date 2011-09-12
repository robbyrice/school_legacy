/* Author: Robert Doucette

*/

var author = {
	init : function(settings) {
		author.config = {
			html : '<p><label>Prénom : </label><input class="prenom" name="prenom[]" />	<label>Surnom : </label><input class="surnom" name="surnom[]" />	<label>Nom : </label><input class="nom" name="nom[]" /> <img class="delete" src="img/001_05.png" /></p>',
			url : 'bib/auteurs'
		};
		author.autocomp('.prenom');
		$.extend(author.config, settings);
	},
	add : function(target) {
		$(target).parent('p').siblings('input').before(author.config.html).prev('p').children('input:first').focus();
		author.autocomp('.prenom');
	},
	autocomp : function(target) {
		$(target).autocomplete({
			autoFocus: true,
			source: author.config.url,
			delay: 0,
			select: function(event, ui) {
				$(this).siblings('.surnom').val(ui.item.surnom).siblings('.nom').val(ui.item.nom).parent('p').next().focus();
			}
		});
	},
	remove : function(target) {
		$(target).parent('p').remove();
	}
};

author.init();
$('#add').click(function(e) {
	author.add(this);
});

$('.delete').live('click', function(e) {
	author.remove(this);
});



$('#titre').autocomplete({
	autoFocus: true,
	source: "bib/livres",
	delay: 0,
	select: function(event, ui){
		$(this).nextAll('input').eq(0).val(ui.item.sous_titre).next().val(ui.item.id).parent('p').next().children('input:first').focus();
	}
});

var cal = {
	
}

$('#cal_show td.cours').live('click', (function(e) {
	$('#box').remove();
	var id = $(this).attr('id'), type = $('#cal_show').attr('data');
	$('body').prepend('<div id="box"></div>').children('div:first').load('cal/admin/box/' + type + '/' + id, function() {
		$(this).hide().slideDown(300, function() {
			$(this).children('p').children('input:first').focus()
			.end().children('input').autocomplete({
				autoFocus: true,
				delay: 0,
				source: "cal/admin/hour",
				select: function(event, ui) {
					$(this).next().val(ui.item.id).next().focus();
				}
			}).siblings('button:first').click(function() {
				//alert($(this).siblings('select').eq(0).val() + $(this).siblings('select').eq(1).val() + '_' + id + '&cours1=' + $(this).siblings('input').eq(1).val() + '&cours2=' + $(this).siblings('input').eq(3).val());return false;
				$.ajax({
					data: 'info=' + $(this).siblings('select').eq(0).val() + '_' + $(this).siblings('select').eq(1).val() + '_' + id + '&cours1=' + $(this).siblings('input').eq(1).val() + '&cours2=' + $(this).siblings('input').eq(3).val(),
					success: function(data)
					{
						$('#cal_show').load(window.location.pathname + ' table');
						$('#box').slideUp(300, function() {
							$(this).empty();
						});
					},
					type: 'POST',
					url: 'cal/admin/jours/' + type
				});
			}).next('button').click(function() {
					$(this).parent('p').parent('div').slideUp(300, function() {
						$(this).empty();
					});
			});
		});
	});
}));