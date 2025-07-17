<?php
/**
 * To Update the Project Details
 */
$id_val = isset($project_details['id']) ? $project_details['id'] : (isset($_POST['id']) ? $_POST['id'] : '');
$code_val = isset($project_details['code']) ? $project_details['code'] : set_value('code');
$name_val = isset($project_details['name']) ? $project_details['name'] : set_value('name');
$type_val = isset($project_details['type']) ? $project_details['type'] : set_value('type');
$loc_val = isset($project_details['location']) ? $project_details['location'] : set_value('location');
$client_val = isset($project_details['client']) ? $project_details['client'] : set_value('client');
$pmc_val = isset($project_details['pm_c']) ? $project_details['pm_c'] : set_value('pm_c');
$dec_val = isset($project_details['de_c']) ? $project_details['de_c'] : set_value('de_c');
$noa_val = isset($project_details['noa']) ? displayDate($project_details['noa']) : set_value('noa');
$completeion_val = isset($project_details['completion_date']) ? displayDate($project_details['completion_date']) : set_value('completion_date');
$extension_val = isset($project_details['extension_date']) ? displayDate($project_details['extension_date']) : set_value('extension_date');
$contract_val = isset($project_details['contract_value']) ? $project_details['contract_value'] : set_value('contract_value');
$contract_val_inr = isset($project_details['contract_value_inr']) ? $project_details['contract_value_inr'] : set_value('contract_value_inr');
$currency_val = isset($project_details['currency']) ? $project_details['currency'] : set_value('currency');
$ex_rate_val = isset($project_details['ex_rate']) ? $project_details['ex_rate'] : set_value('ex_rate');
$note_val = isset($project_details['note']) ? $project_details['note'] : set_value('note');
 ?> 
<div class="modal-dialog modal-xl">
  	<div class="modal-content">
  	   	<form method="post" onsubmit="return false" id="edit_project" enctype="multipart/form-data">
  	   		<input type="hidden" name="id" value="<?= $id_val ?>" />
  	   		<?= csrf_field(); ?>
  	  		<div class="modal-header">
  	  		  <h5 class="modal-title">Edit Project</h5>
  	  		  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
  	  		</div>
  	  		<div class="modal-body">
  	  			<div class="row">
  	  				<div class="col-md-4 col-sm-6 col-xs-12">
  	  		  			<div class="mb-0">
  	  		  			  	<label for="name" class="form-label mb-0">Code&nbsp;<span class="text-danger">*</span>&nbsp;:&nbsp;</label>
  	  		  			  	<input type="text" class="form-control form-control-sm" name="code" id="code" value="<?= $code_val; ?>" placeholder="Please Enter Code">
  	  						<span class="text-danger"><small><?= validation_show_error('code'); ?></small></span>
  	  		  			</div>
  	  		  		</div>
  	  		  		<div class="col-md-4 col-sm-6 col-xs-12">
  	  		  			<div class="mb-0">
  	  		  			  	<label for="name" class="form-label mb-0">Name&nbsp;<span class="text-danger">*</span>&nbsp;:&nbsp;</label>
  	  		  			  	<input type="text" class="form-control form-control-sm" name="name" id="name" value="<?= $name_val; ?>" placeholder="Please Enter Name">
  	  						<span class="text-danger"><small><?= validation_show_error('name'); ?></small></span>
  	  		  			</div>
  	  		  		</div>
  	  		  		<div class="col-md-4 col-sm-6 col-xs-12">
  	  		  			<div class="mb-0">
  	  		  			  	<label for="type" class="form-label mb-0">Short Name&nbsp;<span class="text-danger">*</span>&nbsp;:&nbsp;</label>
  	  		  			  	<input type="text" class="form-control form-control-sm" name="type" id="type" value="<?= $type_val; ?>" placeholder="Please Enter Short Name">
  	  						<span class="text-danger"><small><?= validation_show_error('type'); ?></small></span>
  	  		  			</div>
  	  		  		</div>
  	  		  	</div>
                <div class="hr1"></div>
  	  		  	<div class="row">
  	  		  		<div class="col-md-4 col-sm-6 col-xs-12">
  	  		  			<div class="mb-0">
  	  		  				<label class="form-label mb-0">Location&nbsp;<span class="text-danger">*</span>&nbsp;:&nbsp;</label>
  	  		  				<select class="form-select form-select-sm" name="location" id="location">
  	  		  					<option value="">All</option>
  	  		  					<? foreach ($locations as $key => $value) { ?>
  	  		  						<option value="<?= $value['id']; ?>"<?if($loc_val == $value['id']){ echo "selected";}?>><?= $value['name']; ?></option>
  	  		  					<? } ?>
  	  		  				</select>
  	  						<span class="text-danger"><small><?= validation_show_error('location'); ?></small></span>
  	  					</div>
  	  		  		</div>
  	  		  		<div class="col-md-4 col-sm-6 col-xs-12">
  	  		  			<div class="mb-0">
  	  		  				<label class="form-label mb-0">Client&nbsp;<span class="text-danger">*</span>&nbsp;:&nbsp;</label>
  	  		  				<select class="form-select form-select-sm" name="client" id="client">
  	  		  					<option value="">All</option>
  	  		  					<? foreach ($clients as $key => $value) { ?>
  	  		  						<option value="<?= $value['id']; ?>"<?if($client_val == $value['id']){ echo "selected";}?>><?= $value['name']; ?></option>
  	  		  					<? } ?>
  	  		  				</select>
  	  						<span class="text-danger"><small><?= validation_show_error('client'); ?></small></span>
  	  					</div>
  	  		  		</div>
  	  		  	</div>
                <div class="hr1"></div>
  	  		  	<div class="row">
  	  		  		<div class="col-md-4 col-sm-6 col-xs-12">
  	  		  			<div class="mb-3">
  	  		  			  	<label for="name" class="form-label mb-0">Project Managament Consultant&nbsp;<span class="text-danger">*</span>&nbsp;:&nbsp;</label>
  	  		  			  	<input type="text" class="form-control form-control-sm" name="pm_c" value="<?= $pmc_val; ?>" placeholder="Please Enter Project Mngt. Cslt.">
  	  						<span class="text-danger"><small><?= validation_show_error('pm_c'); ?></small></span>
  	  		  			</div>
  	  		  		</div>
  	  		  		<div class="col-md-4 col-sm-6 col-xs-12">
  	  		  			<div class="mb-3">
  	  		  			  	<label for="name" class="form-label mb-0">Design Engineer Consultant&nbsp;<span class="text-danger">*</span>&nbsp;:&nbsp;</label>
  	  		  			  	<input type="text" class="form-control form-control-sm" name="de_c" value="<?= $dec_val; ?>" placeholder="Please enter Design Eng. Cslt.">
  	  						<span class="text-danger"><small><?= validation_show_error('de_c'); ?></small></span>
  	  		  			</div>
  	  		  		</div>
  	  		  	</div>
                <div class="hr1"></div>
  	  		  	<div class="row">
  	  		  		<div class="col-md-4 col-sm-6 col-xs-12">
	  	  		  		<div class="mb-3">
	  	  		  		  	<label for="name" class="form-label mb-0">Notification of Award&nbsp;<span class="text-danger">*</span>&nbsp;:&nbsp;</label>
                            <div class="input-group input-group-sm date">
	  	  		  		  	    <input type="text" class="form-control" id="noa_date" name="noa" value="<?= $noa_val; ?>" placeholder="DD-MM-YYYY" aria-describedby="noa_date">
                                <span class="input-group-text"><i class="bi bi-calendar4-week"></i></span>
                            </div>
  	  						<span class="text-danger"><small><?= validation_show_error('noa'); ?></small></span>
	  	  		  		</div>
	  	  		  	</div>
  	  		  		<div class="col-md-4 col-sm-6 col-xs-12">
  	  		  			<div class="mb-3">
  	  		  			  	<label for="name" class="form-label mb-0">Completion Date&nbsp;<span class="text-danger">*</span>&nbsp;:&nbsp;</label>
                            <div class="input-group input-group-sm date">
  	  		  			        <input type="text" class="form-control" id="completion_date" name="completion_date" value="<?= $completeion_val; ?>"  placeholder="DD-MM-YYYY">
                                <span class="input-group-text"><i class="bi bi-calendar4-week"></i></span>
                            </div>
  	  						<span class="text-danger"><small><?= validation_show_error('completion_date'); ?></small></span>
  	  		  			</div>
  	  		  		</div>
  	  		  		<div class="col-md-4 col-sm-6 col-xs-12">
  	  		  			<div class="mb-3">
  	  		  			  	<label for="name" class="form-label mb-0">Extension Date&nbsp;<span class="text-danger">*</span>&nbsp;:&nbsp;</label>
                            <div class="input-group input-group-sm date">
  	  		  			        <input type="text" class="form-control" id="extension_date" name="extension_date" value="<?= $extension_val; ?>" placeholder="DD-MM-YYYY">
                                <span class="input-group-text"><i class="bi bi-calendar4-week"></i></span>
                            </div>
  	  						<span class="text-danger"><small><?= validation_show_error('extension_date'); ?></small></span>
  	  		  			</div>
  	  		  		</div>
  	  		  	</div>
                <div class="hr1"></div>
                <div class="row">
                    <div class="col-md-6 col-sm-12 col-xs-12">
          	  		  	<div class="row">
          	  		  		<div class="col-md-6 col-sm-12 col-xs-12">
          	  		  			<div class="mb-3">
          	  		  			  	<label for="name" class="form-label mb-0">Contract Value INR&nbsp;<span class="text-danger">*</span>&nbsp;:&nbsp;</label>
          	  		  			  	<div class="input-group input-group-sm">
          	  		  			  		<input type="text" class="form-control text-end" id="contract_val_inr" name="contract_value_inr" value="<?= $contract_val_inr; ?>" onchange="calculateINR()" placeholder="Please Enter Contract Value in Rupees">
          	  		  			  	</div>
          	  						<span class="text-danger"><small><?= validation_show_error('contract_value_inr'); ?></small></span>
          	  		  			</div>
          	  		  		</div>
          	  		  		<div class="col-md-6 col-sm-12 col-xs-12">
          	  		  			<div class="mb-3">
          	  		  			  	<label for="name" class="form-label mb-0">Contract Value&nbsp;<span class="text-danger">*</span>&nbsp;:&nbsp;</label>
          	  		  			  	<div class="input-group input-group-sm">
          	  		  			  		<input type="text" class="form-control text-end" id="contract_val" name="contract_value" value="<?= $contract_val; ?>" onchange="calculateINR()" placeholder="Please Enter Contract value">
          	  		  			  	</div>
          	  						<span class="text-danger"><small><?= validation_show_error('contract_value'); ?></small></span>
          	  		  			</div>
          	  		  		</div>
                        </div>
                        <div class="row">
          	  		  		<div class="col-md-6 col-sm-12 col-xs-12">
          	  		  			<div class="mb-3">
          	  		  				<label class="form-label mb-0">Currency Type&nbsp;<span class="text-danger">*</span>&nbsp;:&nbsp;</label>
          	  		  				<select class="form-select form-select-sm" name="currency" id="currency">
          	  		  					<option value="">Select</option>
          	  		  					<? foreach ($currencies as $key => $currncy) { ?>
          	  		  						<option value="<?= $key; ?>"<?if($currency_val == $currncy['id']){ echo "selected";}?>><?= $currncy['name']; ?></option>
          	  		  					<? } ?>
          	  		  				</select>
          	  						<span class="text-danger"><small><?= validation_show_error('currency'); ?></small></span>
          	  					</div>
          	  		  		</div>
          	  		  		<div class="col-md-6 col-sm-12 col-xs-12">
          	  		  			<div class="mb-3">
          	  		  				<label for="ex_rate" class="form-label mb-0">Exchange Value&nbsp;<span class="text-danger">*</span>&nbsp;:&nbsp;</label>
          	  		  				<input type="text" id="ex_rate" name="ex_rate" class="form-control form-control-sm text-end" value="<?= $ex_rate_val; ?>" onchange="calculateINR()" placeholder="Please Enter Exchange Rate">
          	  		  				<span class="text-danger"><small><?= validation_show_error('ex_rate'); ?></small></span>
          	  		  			</div>
          	  		  		</div>
          	  		  	</div>
                    </div>
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <div class="bd-callout bd-callout-default m-0 p-2 border-0">
                            <div class="row mb-2">
                                <label class="col-sm-6 col-form-label text-end">Conversion in INR&nbsp;:</label>
                                <label class="col-sm-6 col-form-label text-end"><div id="con_inr"></div></label>
                            </div>
                            <div class="row mb-2">
                                <label class="col-sm-6 col-form-label text-end">Total in INR&nbsp;:</label>
                                <label class="col-sm-6 col-form-label text-end"><div id="tot_inr"></div></label>
                            </div>
                            <div class="row mb-2">
                                <label class="col-sm-6 col-form-label text-end">Total INR(in Crs)&nbsp;:</label>
                                <label class="col-sm-6 col-form-label text-end"><div id="tot_cr"></div></label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="hr1"></div>
  	  		  	<div class="row">
  	  		  		<div class="mb-0">
  	  		  			<label for="form-label">Note</label>
  	  		  			<textarea class="form-control" name="note"><?= $note_val; ?></textarea>
  	  		  		</div>
  	  		  	</div>
  	  		</div>
  	  		<div class="modal-footer">
  	  		  	<button type="button" onclick="updateProject()" class="btn btn-success btn-sm"><i class="bi bi-plus-square"></i>&nbsp;Update Project</button>
  	  		  	<button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal"><i class="bi bi-x-square"></i>&nbsp;Close</button>
  	  		</div>
  	  	</form>
  	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		calculateINR();
	});
</script>
<script type="text/javascript">
    $(function(){
        $('#noa_date').datepicker({format:'dd-mm-YYYY',autoHide:true});
        $('#completion_date').datepicker({format:'dd-mm-YYYY',autoHide:true});
        $('#extension_date').datepicker({format:'dd-mm-YYYY',autoHide:true});
    });
</script>