<form class="form-horizontal" id="ev">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h3>Agregar Evento</h3>
	</div>
	<div class="modal-body">
		<div class="form-group">
			<label class="col-md-4 control-label">Fecha Inicio: </label>
			<div class="col-md-6">
				<input class="form-control" type="text" id="fev" name="fev" placeholder="Ingrese Fecha (dd/mm/yyyy)">
			</div>			
		</div>
		<div class="form-group">
			<label class="col-md-4 control-label">Hora Inicio: </label>
			<div class="col-md-6">
				<input class="form-control" type="text" id="hev" name="hev" value="" placeholder="Ingrese Hora (hh:mm)">
			</div>
		</div>	
		<div class="form-group">
			<label class="col-md-4 control-label">Fecha Final: </label>
			<div class="col-md-6">
				<input class="form-control" type="text" id="ffv" name="ffv" placeholder="Ingrese Fecha (dd/mm/yyyy)">
			</div>			
		</div>
		<div class="form-group">
			<label class="col-md-4 control-label">Hora Final: </label>
			<div class="col-md-6">
				<input class="form-control" type="text" id="hfv" name="hfv" value="" placeholder="Ingrese Hora (hh:mm)">
			</div>
		</div>		
		<div class="form-group">
			<label class="col-md-4 control-label">Título: </label>
			<div class="col-md-6">
				<input type="text" class="form-control" id="tev" name="tev" placeholder="Ingrese Titulo">
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-4 control-label">Detalle: </label>
			<div class="col-md-6">
				<textarea class="form-control" rows="10" id="tev" name="tev" placeholder="Ingrese Detalle (máximo 200 caracteres)" maxlength="200"></textarea>
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<div class="form-group">
			<div class="col-md-6 col-md-offset-4">
				<button type="button" class="btn btn-primary" id="agev" ><i class="fa fa-plus"></i> Grabar</button>
				<button type="button" class="btn btn-warning" id="rev"><i class="fa fa-reset"></i> Limpiar</button>
				<button type="button" class="btn btn-danger" id="cev" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>	
			</div>
		</div>
	</div>
</form>
