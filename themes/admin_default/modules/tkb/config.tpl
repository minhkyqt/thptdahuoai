<!-- BEGIN: main -->
<link type="text/css" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.css" rel="stylesheet" />
<!-- BEGIN: result_action -->
<div class="alert alert-info">
	{RESULT_ACTION}
</div>
<!-- END: result_action -->
<form action="{FORM_ACTION}" method="post">
	<div class="row">
		<div class="col-sm-24 col-md-24">
			<div class="table-responsive">
				<table class="table table-striped table-bordered table-hover">
					<tbody>
						<tr>
							<td class="text-right">Tiêu đề TKB lớp</td>
							<td>
								<input class="form-control" type="text" name="title_tkb_lop" placeholder="Nhập tiêu đề khi xem TKB lớp" value="{TITLE_TKB_LOP}">
							</td>
						</tr>
						<tr>
							<td class="text-right">Tiêu đề TKB giáo viên</td>
							<td>
								<input class="form-control" type="text" name="title_tkb_gv" placeholder="Nhập tiêu đề khi xem TKB giáo viên" value="{TITLE_TKB_GV}">
							</td>
						</tr>
						<tr>
							<td class="text-right">Ngày áp dụng TKB</td>
							<td>
								<div class="form-group" style="width:260px;">
									<div class="input-group">
										<input type="text" class="form-control" name="day_apply" id="day_apply" readonly="readonly" placeholder="Chọn ngày áp dụng" value="{DAY_APPLY}">
										<span class="input-group-btn">
											<button class="btn btn-default" type="button" id="day_apply-btn">
												<em class="fa fa-calendar fa-fix">&nbsp;</em>
											</button> </span>
									</div>
								</div>
							</td>
						</tr>
						<tr>
							<td class="text-right"></td>
							<td><input type="submit" value="Lưu lại" name="do" class="btn btn-info"/></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</form>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/language/jquery.ui.datepicker-{NV_LANG_INTERFACE}.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		if( $.fn.datepicker ){
			$("#day_apply").datepicker({
				dateFormat : "dd/mm/yy",
				changeMonth : true,
				changeYear : true,
				showOtherMonths : true,
				showOn : 'focus'
			});
		}
		$('#day_apply-btn').click(function(){
			$("#day_apply").datepicker('show');
		});
	});
</script>
<!-- END: main -->