<div class="modal-dialog modal-xl">
  	<div class="modal-content">
  	   	<form method="post" onsubmit="return false" id="add_project" enctype="multipart/form-data">
  	   		<?= csrf_field() ?>
  	  		<div class="modal-header">
  	  		  <h5 class="modal-title">Add Project</h5>
  	  		  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
  	  		</div>
  	  		<div class="modal-body">
  	  			<div class="row">
  	  				<div class="col-md-4 col-sm-6 col-xs-12">
  	  		  			<div class="mb-0">
  	  		  			  	<label for="code" class="form-label mb-0">Code&nbsp;<span class="text-danger">*</span>&nbsp;:&nbsp;</label>
  	  		  			  	<input type="text" class="form-control form-control-sm" name="code" id="code" value="<?= set_value('code'); ?>" placeholder="Please Enter Code">
  	  						<span class="text-danger"><?= validation_show_error('code'); ?></span>
  	  		  			</div>
  	  		  		</div>
  	  		  		<div class="col-md-4 col-sm-6 col-xs-12">
  	  		  			<div class="mb-0">
  	  		  			  	<label for="name" class="form-label mb-0">Name&nbsp;<span class="text-danger">*</span>&nbsp;:&nbsp;</label>
  	  		  			  	<input type="text" class="form-control form-control-sm" name="name" id="name" value="<?= set_value('name'); ?>" placeholder="Please Enter Name">
  	  						<span class="text-danger"><?= validation_show_error('name'); ?></span>
  	  		  			</div>
  	  		  		</div>
  	  		  		<div class="col-md-4 col-sm-6 col-xs-12">
  	  		  			<div class="mb-0">
  	  		  			  	<label for="type" class="form-label mb-0">Short Name&nbsp;<span class="text-danger">*</span>&nbsp;:&nbsp;</label>
  	  		  			  	<input type="text" class="form-control form-control-sm" name="type" id="type" value="<?= set_value('type'); ?>" placeholder="Please Enter Short Name">
  	  						<span class="text-danger"><?= validation_show_error('type'); ?></span>
  	  		  			</div>
  	  		  		</div>
  	  		  	</div>
                <div class="hr1"></div>
  	  		  	<div class="row">
  	  		  		<div class="col-md-4 col-sm-6 col-xs-12">
  	  		  			<div class="mb-0">
  	  		  				<label class="form-label mb-0">Location&nbsp;<span class="text-danger">*</span>&nbsp;:&nbsp;</label>
  	  		  				<select class="form-select form-select-sm" name="location" id="location">
  	  		  					<option value="">Select</option>
  	  		  					<? foreach ($locations as $key => $value) { ?>
  	  		  						<option value="<?= $value['id']; ?>"<?if(set_value('location') == $value['id']){ echo "selected";}?>><?= $value['name']; ?></option>
  	  		  					<? } ?>
  	  		  				</select>
  	  						<span class="text-danger"><?= validation_show_error('location'); ?></span>
  	  					</div>
  	  		  		</div>
  	  		  		<div class="col-md-4 col-sm-6 col-xs-12">
  	  		  			<div class="mb-0">
  	  		  				<label class="form-label mb-0">Client&nbsp;<span class="text-danger">*</span>&nbsp;:&nbsp;</label>
  	  		  				<select class="form-select form-select-sm" name="client" id="client">
  	  		  					<option value="">Select</option>
  	  		  					<? foreach ($clients as $key => $value) { ?>
  	  		  						<option value="<?= $value['id']; ?>"<?if(set_value('client') == $value['id']){ echo "selected";}?>><?= $value['name']; ?></option>
  	  		  					<? } ?>
  	  		  				</select>
  	  						<span class="text-danger"><?= validation_show_error('client'); ?></span>
  	  					</div>
  	  		  		</div>
  	  		  	</div>
                <div class="hr1"></div>
  	  		  	<div class="row">
  	  		  		<div class="col-md-4 col-sm-6 col-xs-12">
  	  		  			<div class="mb-0">
  	  		  			  	<label for="pm_c" class="form-label mb-0" title="Project Management Consultant">PMC&nbsp;<span class="text-danger">*</span>&nbsp;:&nbsp;</label>
  	  		  			  	<input type="text" class="form-control form-control-sm" name="pm_c" value="<?= set_value('pm_c'); ?>" placeholder="Please Enter Project Mngt. Cslt.">
  	  						<span class="text-danger"><?= validation_show_error('pm_c'); ?></span>
  	  		  			</div>
  	  		  		</div>
  	  		  		<div class="col-md-4 col-sm-6 col-xs-12">
  	  		  			<div class="mb-0">
  	  		  			  	<label for="de_c" class="form-label mb-0" title="Design Engineer Consultant">DEC&nbsp;<span class="text-danger">*</span>&nbsp;:&nbsp;</label>
  	  		  			  	<input type="text" class="form-control form-control-sm" name="de_c" value="<?= set_value('de_c'); ?>" placeholder="Please Enter Design Eng. Cslt.">
  	  						<span class="text-danger"><?= validation_show_error('de_c'); ?></span>
  	  		  			</div>
  	  		  		</div>
  	  		  	</div>
                <div class="hr1"></div>
  	  		  	<div class="row">
  	  		  		<div class="col-md-4 col-sm-6 col-xs-12">
	  	  		  		<div class="mb-0">
	  	  		  		  	<label for="noa_date" class="form-label mb-0" title="Notification of Award">NOA&nbsp;<span class="text-danger">*</span>&nbsp;:&nbsp;</label>
                            <div class="input-group input-group-sm date">
                                <input type="text" name="noa" id="noa_date" class="form-control" value="<?= set_value('noa'); ?>" placeholder="DD-MM-YYYY">
                                <span class="input-group-text" ><i class="bi bi-calendar4-week"></i></span>
                            </div>
	  	  					<span class="text-danger"><?= validation_show_error('noa'); ?></span>
	  	  		  		</div>
	  	  		  	</div>
  	  		  		<div class="col-md-4 col-sm-6 col-xs-12">
  	  		  			<div class="mb-0">
  	  		  			  	<label for="completion_date" class="form-label mb-0">Completion Date&nbsp;<span class="text-danger">*</span>&nbsp;:&nbsp;</label>
                            <div class="input-group input-group-sm date">
      	  		  			  	<input type="text" class="form-control"  id="completion_date" name="completion_date" value="<?= set_value('completion_date'); ?>" placeholder="DD-MM-YYYY">
                                <span class="input-group-text"><i class="bi bi-calendar4-week"></i></span>
                            </div>
  	  						<span class="text-danger"><?= validation_show_error('completion_date'); ?></span>
  	  		  			</div>
  	  		  		</div>
  	  		  		<div class="col-md-4 col-sm-6 col-xs-12">
  	  		  			<div class="mb-0">
  	  		  			  	<label for="extension_date" class="form-label mb-0">Extension Date&nbsp;<span class="text-danger">*</span>&nbsp;:&nbsp;</label>
                            <div class="input-group input-group-sm date">
  	  		  			  	    <input type="text" class="form-control" id="extension_date" name="extension_date" value="<?= set_value('extension_date'); ?>" placeholder="DD-MM-YYYY">
                                <span class="input-group-text"><i class="bi bi-calendar4-week"></i></span>
                            </div>
  	  						<span class="text-danger"><?= validation_show_error('extension_date'); ?></span>
  	  		  			</div>
  	  		  		</div>
  	  		  	</div>
                <div class="hr1"></div>
                <div class="row">
                    <div class="col-md-6 col-sm-12 col-xs-12">
          	  		  	<div class="row">
          	  		  		<div class="col-md-6 col-sm-6 col-xs-12">
          	  		  			<div class="mb-3">
          	  		  			  	<label for="contract_val_inr" class="form-label mb-0">Contract Value INR&nbsp;<span class="text-danger">*</span>&nbsp;:&nbsp;</label>
          	  		  			  	<div class="input-group input-group-sm">
          	  		  			  		<input type="text" class="form-control form-control-sm text-end" id="contract_val_inr" name="contract_value_inr" value="<?= set_value('contract_value_inr'); ?>" onchange="calculateINR()" placeholder="Please Enter Contract Value in rupees">
          	  		  			  	</div>
          	  						<span class="text-danger"><?= validation_show_error('contract_value_inr'); ?></span>
          	  		  			</div>
          	  		  		</div>
          	  		  		<div class="col-md-6 col-sm-6 col-xs-12">
          	  		  			<div class="mb-3">
          	  		  			  	<label for="contract_val" class="form-label mb-0">Contract Value<small>[USD,PONDS,EUROS]</small>&nbsp;<span class="text-danger">*</span>&nbsp;:&nbsp;</label>
          	  		  			  	<div class="input-group input-group-sm">
          	  		  			  		<input type="text" class="form-control form-control-sm text-end" id="contract_val" name="contract_value" value="<?= set_value('contract_value'); ?>" onchange="calculateINR()" placeholder="Please Enter Contract Value">
          	  		  			  	</div>
          	  						<span class="text-danger"><?= validation_show_error('contract_value'); ?></span>
          	  		  			</div>
          	  		  		</div>
                        </div>
                        <div class="row">
          	  		  		<div class="col-md-6 col-sm-6 col-xs-12">
          	  		  			<div class="mb-0">
          	  		  				<label class="form-label mb-0" for="currency">Currency Type&nbsp;<span class="text-danger">*</span>&nbsp;:&nbsp;</label>
          	  		  				<select class="form-select form-select-sm" name="currency" id="currency">
          	  		  					<option value="">Select</option>
          	  		  					<? foreach ($currencies as $key => $value) { ?>
          	  		  						<option value="<?= $key; ?>"<?if(set_value('currency') == $value['id']){ echo "selected";}?>><?= $value['name']; ?></option>
          	  		  					<? } ?>
          	  		  				</select>
          	  						<span class="text-danger"><?= validation_show_error('currency'); ?></span>
          	  					</div>
          	  		  		</div>
          	  		  		<div class="col-md-6 col-sm-6 col-xs-12">
          	  		  			<div class="mb-0">
          	  		  				<label for="ex_rate" class="form-label mb-0">Exchange Value&nbsp;<span class="text-danger">*</span>&nbsp;:&nbsp;</label>
          	  		  				<input type="text" id="ex_rate" name="ex_rate" class="form-control form-control-sm text-end" value="<?= set_value('ex_rate'); ?>" onchange="calculateINR()" placeholder="Please Enter Exchange Rate">
          	  		  				<span class="text-danger"><?= validation_show_error('ex_rate'); ?></span>
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
      	  		  			<div class="row mb-0">
      	  		  				<label class="col-sm-6 col-form-label text-end">Total INR(In Crs)&nbsp;:</label>
      	  		  				<label class="col-sm-6 col-form-label text-end"><div id="tot_cr"></div></label>
      	  		  			</div>                            
                        </div>
                    </div>
                </div>
                <div class="hr1"></div>
  	  		  	<div class="row">
  	  		  		<div class="mb-3">
  	  		  			<label for="form-label mb-0">Note&nbsp;:&nbsp;</label>
  	  		  			<textarea class="form-control" name="note" placeholder="Description"></textarea>
  	  		  		</div>
  	  		  	</div>
  	  		</div>
  	  		<div class="modal-footer">
  	  		  	<button type="button" onclick="insertProject()" class="btn btn-success btn-sm"><i class="bi bi-plus-square"></i>&nbsp;Add Project</button>
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
        $('#noa_date').datepicker({format:"dd-mm-YYYY", autoHide:true});
        $('#completion_date').datepicker({format:"dd-mm-YYYY", autoHide:true});
        $('#extension_date').datepicker({format:"dd-mm-YYYY", autoHide:true});
    });
</script>