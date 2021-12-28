<!-- BEGIN: main -->
<link rel="stylesheet" type="text/css" href="{LINK_CSS_SELECT2}" />
	<h2 class="text-center">{TITLE_TKB}</h2>
	<p class="text-center">{LANG.apply_from_day}: <strong>{DAY_APPLY}</strong></p>
	<!-- BEGIN: block_table -->
	<form method="post">
		<div align="center">
			<select id="select_Lop" name="keywords" class="form-control" style="width: 300px;">
				<option value="0">{LANG.select_gv}</option>
				<!-- BEGIN: loop_ds-->
					<option value="{GV}">{GV}</option>
				<!-- END: loop_ds -->
				<!-- BEGIN: loop_ds_selected-->
					<option value="{GV}" selected>{GV}</option>
				<!-- END: loop_ds_selected -->
			</select>
			<button class="btn btn-info" value="click" type="submit" style="display:display: inline-block;margin-left: 10px;">{LANG.search}</button>
		</div>
	</form>
	<!-- END: block_table -->
	<!-- BEGIN: block_tablekq -->
		<!-- BEGIN: block_show_sang -->
		<h3 class="text-center" style="margin-top: 10px">{LANG.time0}</h3>
		<table class="table table-bordered" style="margin-top: 10px">
			<tr style="background: #eee;">
				<th class="text-center">{LANG.tiet}</th>
				<th class="text-center">{LANG.thu2}</th>
				<th class="text-center">{LANG.thu3}</th>
				<th class="text-center">{LANG.thu4}</th>
				<th class="text-center">{LANG.thu5}</th>
				<th class="text-center">{LANG.thu6}</th>
				<th class="text-center">{LANG.thu7}</th>
			</tr>
			<!-- BEGIN:loop_kq -->
			<tr class="tiet">
				<td class="text-center" style="background: #c5f5f5;">{TKB.0}</td>
				<td class="text-center">{TKB.1}</td>
				<td class="text-center">{TKB.2}</td>
				<td class="text-center">{TKB.3}</td>
				<td class="text-center">{TKB.4}</td>
				<td class="text-center">{TKB.5}</td>
				<td class="text-center">{TKB.6}</td>
			</tr>
			<!-- END:loop_kq -->
		</table>
		<!-- END: block_show_sang -->
		<!-- BEGIN: block_show_chieu -->
		<h3 class="text-center">{LANG.time1}</h3>
		<table class="table table-bordered" style="margin-top: 10px">
			<tr style="background: #eee;">
				<th class="text-center">{LANG.tiet}</th>
				<th class="text-center">{LANG.thu2}</th>
				<th class="text-center">{LANG.thu3}</th>
				<th class="text-center">{LANG.thu4}</th>
				<th class="text-center">{LANG.thu5}</th>
				<th class="text-center">{LANG.thu6}</th>
				<th class="text-center">{LANG.thu7}</th>
			</tr>
			<!-- BEGIN:loop_kq -->
			<tr class="tiet">
				<td class="text-center" style="background: #c5f5f5;">{TKB.0}</td>
				<td class="text-center">{TKB.1}</td>
				<td class="text-center">{TKB.2}</td>
				<td class="text-center">{TKB.3}</td>
				<td class="text-center">{TKB.4}</td>
				<td class="text-center">{TKB.5}</td>
				<td class="text-center">{TKB.6}</td>
			</tr>
			<!-- END:loop_kq -->
		</table>
		<!-- END: block_show_chieu -->
	<!-- END: block_tablekq -->
<script	type="text/javascript" src="{LINK_JS_SELECT2}"></script>
<script type="text/javascript">
	$(document).ready(function() {
	  	$("#select_Lop").select2();
	});
</script>
<!-- END: main -->