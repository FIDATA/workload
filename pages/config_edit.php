<?php
	require_once('api.php');
	
	form_security_validate( 'plugin_workload_config_edit' );

	auth_reauthenticate( );
	access_ensure_global_level( plugin_config_get( 'manage_threshold' ) );

	$f_workload_status_level = gpc_get_int( 'workload_status_level', PLUGIN_WORKLOAD_ISSUE_STATUS_LEVEL_DEFAULT);
	log_workload_event('Configuration - new workload issue level: '.$f_workload_status_level);

	$f_workload_status_threshold = gpc_get_int( 'workload_status_threshold', PLUGIN_WORKLOAD_ISSUE_STATUS_THRSHD_DEFAULT);
	log_workload_event('Configuration - new workload issue threshold: '.$f_workload_status_threshold);

	$f_progress_status_level = gpc_get_int( 'progress_status_level', PLUGIN_WORKLOAD_ISSUE_STATUS_LEVEL_DEFAULT);
	log_workload_event('Configuration - new progress issue level: '.$f_progress_status_level);
	
	$f_progress_status_threshold = gpc_get_int( 'progress_status_threshold', PLUGIN_WORKLOAD_ISSUE_STATUS_THRSHD_DEFAULT);
	log_workload_event('Configuration - new progress issue threshold: '.$f_progress_status_threshold);
	
	$f_workload_est_var = gpc_get_int( 'workload_est_var_idx', PLUGIN_WORKLOAD_VAR_IDX_NONE );
	log_workload_event('Configuration - new estimated workload custom field: '.$f_workload_est_var);

	$f_workload_done_var = gpc_get_int( 'workload_done_var_idx', PLUGIN_WORKLOAD_VAR_IDX_NONE );
	log_workload_event('Configuration - new done workload custom field: '.$f_workload_done_var);

	$f_progress_var = gpc_get_int( 'progress_var_idx', PLUGIN_WORKLOAD_VAR_IDX_NONE );
	log_workload_event('Configuration - new progress custom field: '.$f_progress_var);	
	
	$f_manage_threshold = gpc_get_int( 'manage_threshold', ADMINISTRATOR );
	log_workload_event('Configuration - new manage threshold: '.$f_manage_threshold);

	layout_page_header( null, plugin_page( 'config', true ) );
	layout_page_begin();
	
	print_manage_menu();
	
	if($f_workload_est_var != PLUGIN_WORKLOAD_VAR_IDX_NONE && 
		$f_workload_done_var != PLUGIN_WORKLOAD_VAR_IDX_NONE &&
		$f_progress_var != PLUGIN_WORKLOAD_VAR_IDX_NONE) {	
		if($f_workload_est_var != $f_workload_done_var && 
			$f_workload_est_var != $f_progress_var &&
			$f_workload_done_var != $f_progress_var) {
			if( plugin_config_get( 'workload_est_var_idx' ) != $f_workload_est_var ) {
				plugin_config_set( 'workload_est_var_idx', $f_workload_est_var );
			}
		
			if( plugin_config_get( 'workload_done_var_idx' ) != $f_workload_done_var ) {
				plugin_config_set( 'workload_done_var_idx', $f_workload_done_var );
			}
			
			if( plugin_config_get( 'progress_var_idx' ) != $f_progress_var ) {
				plugin_config_set( 'progress_var_idx', $f_progress_var );
			}

			if( plugin_config_get( 'workload_status_level' ) != $f_workload_status_level ) {
				plugin_config_set( 'workload_status_level', $f_workload_status_level );
			}
			
			if( plugin_config_get( 'workload_status_threshold' ) != $f_workload_status_threshold ) {
				plugin_config_set( 'workload_status_threshold', $f_workload_status_threshold );
			}

			if( plugin_config_get( 'progress_status_level' ) != $f_progress_status_level ) {
				plugin_config_set( 'progress_status_level', $f_progress_status_level );
			}

			if( plugin_config_get( 'progress_status_threshold' ) != $f_progress_status_threshold ) {
				plugin_config_set( 'progress_status_threshold', $f_progress_status_threshold );
			}
			
			if( plugin_config_get( 'manage_threshold' ) != $f_manage_threshold ) {
				plugin_config_set( 'manage_threshold', $f_manage_threshold );
			}

			html_operation_successful( plugin_page( 'config', true ) );
			
		} else if ($f_workload_est_var == $f_workload_done_var){
			log_workload_event('Configuration - error: same customer field for both estimated and done workloads');
			
			error_parameters( lang_get( 'plugin_workload_est_var' ), $f_workload_est_var );
			trigger_error( ERROR_CONFIG_OPT_INVALID, WARNING );		
		} else if ($f_workload_est_var == $f_progress_var){
			log_workload_event('Configuration - error: same customer field for estimated workload and progress');
			
			error_parameters( lang_get( 'plugin_workload_est_var' ), $f_workload_est_var );
			trigger_error( ERROR_CONFIG_OPT_INVALID, WARNING );		
		} else {
			log_workload_event('Configuration - error: same customer field for done workload and progress');
			
			error_parameters( lang_get( 'plugin_workload_done_var' ), $f_workload_done_var );
			trigger_error( ERROR_CONFIG_OPT_INVALID, WARNING );				
		}
	} else {
		log_workload_event('Configuration - error: customer fields for estimated, done workloads and progress are not defined');
			
		error_parameters( lang_get( 'plugin_workload_est_var' ), $f_workload_est_var );
		trigger_error( ERROR_CONFIG_OPT_INVALID, WARNING );	
	}
	
	layout_page_end();
	
?>