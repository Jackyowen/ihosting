<?php
function wp_awhmcs_shortcode(){
?>
	<!-- <h2>Begin the search for your perfect domain name...</h2> -->
	<div class="sdomainchecker">
	<domain-checker template-url="pages/blocks/sdomainchecker.html"></domain-checker>
	</div>
<?php
}
add_shortcode('awhmcs', 'wp_awhmcs_shortcode');

function wp_awhmcs_main(){
?>
	<div class="whmcs">
		<div><awhmcs-header></awhmcs-header></div>
		<div class="content" ng-view></div>
	</div>
<?php
}
add_shortcode('awhmcs-app', 'wp_awhmcs_main');