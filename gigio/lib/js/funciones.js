function dv(rut){
	var dig=0,digito=1;
	var ver;
	for(;rut;rut=Math.floor(rut/10)){
		digito=(digito+rut%10*(9-dig++%6))%11;
	}
	ver=digito?digito-1:'K';
	return ver;
}
function contarCaracteres(campo, conteo, limite) {
	if (document.form[0].obs.value.length > limite) {
		document.form[0].obs.value = document.form[0].obs.value.substring(0, limite);
	}else {
		conteo = limite - document.form[0].obs.value;
	}
}