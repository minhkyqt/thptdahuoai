<!-- BEGIN: main -->
<div class="wrap">
	{MESSAGE}	
	<div class="litespeed-cache-welcome-panel">
		<p>{LANG.123HOST_MAIN_INTRO}</p>
		
		<table class="form-table">
			<tbody>
			<tr>
					<th>{LANG.123host_cache_statuss}</th>
					<td>
						{CACHE_STATUS} 
					</td>
				</tr>
				<!-- <tr> 
					<th>Kiểm tra tương thích</th>
					<td>
						<a href="index.php?language=vi&nv=litespeedcache&op=main&action=checkRequirement" class="litespeed-btn litespeed-btn-success">
							Kiểm tra tương thích			
						</a>
						<div class="litespeed-desc">
							Kiểm tra tương thích của hệ thống
						</div>
					</td>
				</tr> -->
				
				<tr>
					<th>{LANG.123host_cache_action}</th>
					<td>
						{CACHE_BUTTON}
						<div class="litespeed-desc">
							{LANG.123host_cache_action}
						</div>
					</td>
				</tr>
								
				<tr>
					<th>{LANG.123HOST_MAIN_TL2}</th>
					<td>
						{PURGE_CACHE_FRONT_BUTTON}
						<div class="litespeed-desc">
							{LANG.123HOST_MAIN_TL4}				
						</div>
					</td>
				</tr>

				<tr>
					<th>{LANG.123HOST_MAIN_TL5}</th>
					<td>
						{PURGE_CACHE_ALL_BUTTON}
						<div class="litespeed-desc">
								 {LANG.123HOST_MAIN_TL7}				
						</div>
					</td>
				</tr>
			</tbody>
		</table>
		<div> 
		<div><p class="text-center text-muted">{LANG.123host_power_by_footer}</p></div>
	</div>
	</div>
	
</div>

<!-- END: main -->
