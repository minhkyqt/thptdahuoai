<!-- BEGIN: config -->

<div class="wrap">
	<div>
		<h2 class="nav-tab-wrapper">
			<a class="nav-tab litespeed-tab" href="#general" data-litespeed-tab="general">{LANG.123host_general_config}</a>
			<a class="nav-tab litespeed-tab nav-tab-active" href="#specific" data-litespeed-tab="specific">{LANG.123host_specific_pages}</a>
		</h2>
	</div>
	<div class="litespeed-cache-welcome-panel">
		<p>{MESSAGE}</p>
		<form method="post" action="" id="litespeed_form_options">
			<div data-litespeed-layout="general" style="display: none;">
				<h3 class="litespeed-title">{LANG.123host_information}</h3>

				<table class="form-table">
					<tbody>

						<tr>
							<th>{LANG.123host_public_cache_ttl}</th>
							<td>
								<input type="text" class="regular-text " name="public_cache_ttl" value="{PUBLIC_CACHE_TTL}"> {LANG.123host_seconds}
								<div class="litespeed-desc">
									{LANG.123host_front_cache_ttl_des}
								</div>
							</td>
						</tr>
						<tr>
							<th>{LANG.123host_front_cache_ttl}</th>
							<td>
								<input type="text" class="regular-text " name="front_page_cache_ttl" value="{FRONT_PAGE_CACHE_TTL}"> {LANG.123host_seconds}
								<div class="litespeed-desc">
									{LANG.123host_front_cache_ttl_des}
									</div>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div data-litespeed-layout="specific" style="display: block;">
				<h3 class="litespeed-title">{LANG.123host_information}</h3>
				<table class="form-table">
					<tbody>
						<tr>
							<th>{LANG.123host_cache_login_page}</th>
							<td>
								<div class="litespeed-row">
									<div class="litespeed-switch litespeed-label-info">
										<input type="radio" name="cache_login_page" id="conf_cache_login_1" value="1" {ENABLE_CACHE_LOGIN_PAGE_CHECKED}>
										<label for="conf_cache_login_1">{LANG.123host_enable}</label>
										<input type="radio" name="cache_login_page" id="conf_cache_login_0"
										    value="0" {DISABLE_CACHE_LOGIN_PAGE_CHECKED}>
										<label for="conf_cache_login_0">{LANG.123host_disable}</label>
									</div>
								</div>
								<div class="litespeed-desc">
									{LANG.123host_cache_login_page_des} </div>
							</td>
						</tr>
						<tr>
							<th>{LANG.123host_cache_favicon}</th>
							<td>
								<div class="litespeed-row">
									<div class="litespeed-switch litespeed-label-info">
										<input type="radio" name="cache_favicon" id="conf_cache_favicon_1" value="1" {ENABLE_CACHE_FAVICON_CHECKED}>
										<label for="conf_cache_favicon_1">{LANG.123host_enable}</label>
										<input type="radio" name="cache_favicon"  id="conf_cache_favicon_0" value="0"  {DISABLE_CACHE_FAVICON_CHECKED}> 
										<label for="conf_cache_favicon_0">{LANG.123host_disable}</label> </div>
								</div>
								<div class="litespeed-desc">
									{LANG.123host_cache_favicon_des}</div>
							</td>
						</tr>
						<!-- build_setting_cache_resources -->
					</tbody>
				</table>
			</div>

			<div class="litespeed-top20"></div>
			<p class="submit"><input type="submit" name="litespeed-submit" id="litespeed-submit" class="btn btn-primary" value="{LANG.save}"></p>
		</form>
	</div>
</div>

<!-- END: config -->