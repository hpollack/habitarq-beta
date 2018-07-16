function validaRut(rut) {
    var rut = rut;
    var cont = 2; //contador
    var suma = 0; //el resultado de la suma de los numeros

    var nrut = rut.split(""); // se guardan los digitos separados

    /*
     * El array resultante (nrut) se debe recorrer desde la última posición
     * a cada valor por separado se le multiplica con el cont el cual irá
     * incrementandose de uno en uno, hasta 7. Sobore
     */

    for (var i = nrut.length - 1; i >= 0; i--) {
        if (cont == 8) {
            // Si el contador es superior a 7, se reinicia.			
            cont = 2;
        }
        // Se transforma cada dígito en un numero entero y se multiplica por el contador
        suma += parseInt(nrut[i]) * cont;
        cont++;
    }
    /*
     * La variable dvr, almacena el resultado de la operación matemática siguiente
     * la cual consta de dividir por 11 el resultado de la multiplicacion anterior
     * y luego aplicar una resta 11 - el módulo (resto de la división). Retornará entonces 
     * el dígito verificador de acuerdo al resultado de la operación.
     */
    var dv = (11 - (suma % 11));

    if (dv == 11) {
        // Si es igual 11, devuelve un 0
        return 0;
    } else if (dv == 10) {
        // Si es igual a 10, devuelve una K
        return 'K';
    } else {
        // En caso contrario devuelve el numero resultante.
        return dv;
    }
}


/*function dv(rut){
	var dig=0,digito=1;
	var ver;
	for(;rut;rut=Math.floor(rut/10)){
		digito=(digito+rut%10*(9-dig++%6))%11;
	}
	ver=digito?digito-1:'K';
	return ver;
}
*/



/*function contarCaracteres(campo, conteo, limite) {
	if (document.form[0].obs.value.length > limite) {
		document.form[0].obs.value = document.form[0].obs.value.substring(0, limite);
	}else {
		conteo = limite - document.form[0].obs.value;
	}
}*/