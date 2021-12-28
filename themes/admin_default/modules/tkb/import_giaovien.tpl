<!-- BEGIN: main -->
<!-- BEGIN: error -->
<div class="alert alert-danger">
	{ERROR}
</div>
<!-- END: error -->
<!-- BEGIN: success -->
<div class="alert alert-success">
	{SUCCESS}
</div>
<!-- END: success -->
<form action="{FORM_ACTION}" method="post" enctype="multipart/form-data">
	<div class="row">
		<div class="col-sm-24 col-md-24">
			<div class="table-responsive">
				<table class="table table-striped table-bordered table-hover">
					<tbody>
						<tr>
							<td class="text-right">{LANG.select_gv_time} <sup class="required">(*)</sup><br><small class="text-danger">{LANG.require_select_correct_time}</small></td>
							<td>
								<select name="buoi" class="form-control w200">
									<option value="0">{LANG.time_0}</option>
									<option value="1">{LANG.time_1}</option>
								</select>
							</td>
						</tr>
						<tr>
							<td class="text-right">{LANG.upload_file_excel} <sup class="required">(*)</sup><br><small class="text-danger">{LANG.require_select_correct_file} <a href="#">{LANG.here}</a></small></td>
							<td><input class="w300 form-control pull-left" type="file" name="ufile" id="ufile"/></td>
						</tr>
						<tr>
							<td class="text-right"></td>
							<td><input type="submit" value="{LANG.import}" name="do" class="btn btn-info"/></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</form>
<!-- END: main -->