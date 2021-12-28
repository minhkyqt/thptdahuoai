<!-- BEGIN: main -->
<!-- BEGIN: result_del -->
<div class="alert alert-success">
	{RESULT_DEL}
</div>
<!-- END: result_del -->
<form action="{FORM_ACTION}" method="post">
	<input type="text" name="del" value="1" hidden>

	<a href="{URL_IMPORT_LOP}" class="btn btn-success">{LANG.import_lop}</a>&nbsp;&nbsp;<a href="{URL_IMPORT_GV}" class="btn btn-success">{LANG.import_giaovien}</a>&nbsp;&nbsp;<button type="submit" class="btn btn-danger">{LANG.del_all_data}</button>
</form>
<!-- END: main -->