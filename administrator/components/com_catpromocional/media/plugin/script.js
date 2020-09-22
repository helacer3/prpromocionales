$(function() {
	// Single select
	$(".cls_proveedor, .cls_catpadre, .cls_categoria").chosen({
		search_contains: true,
		no_results_text: 'No se encontraron estos tags'
	});
	// Multiple select
	$(".cls_categorias, .cls_categorias, .cls_tecnicas, .cls_paises, .cls_prdrelacionados, .cls_productos, .cls_usuarios").chosen({
		search_contains: true,
		no_results_text: 'No se encontraron estos tags'
	});
});