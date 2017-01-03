function dv(rut){
	var dig=0,digito=1;
	var ver;
	for(;rut;rut=Math.floor(rut/10)){
		digito=(digito+rut%10*(9-dig++%6))%11;
	}
	ver=digito?digito-1:'K';
	return ver;
}
