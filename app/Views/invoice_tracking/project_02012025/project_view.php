<div class="modal-dialog modal-xl">
  	<div class="modal-content">
  	  	<div class="modal-header">
  	  	  <h5 class="modal-title">View Project(<?= $project_info['code']; ?>)</h5>
  	  	  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
  	  	</div>
  	  	<div class="modal-body">
  			<div class="row">
  				<div class="col-md-4 col-sm-6 col-xs-12">
  		  			<div class="mb-0">
  		  			  	<div class="form-view-name">Code</div>
  		  			  	<div class="form-view-value"><?= $project_info['code']; ?></div>
  		  			</div>
  		  		</div>
  		  		<div class="col-md-4 col-sm-6 col-xs-12">
  		  			<div class="mb-0">
  		  			  	<div class="form-view-name">Name</div>
  		  			  	<div class="form-view-value"><?= $project_info['name']; ?></div>
  		  			</div>
  		  		</div>
  		  		<div class="col-md-4 col-sm-6 col-xs-12">
  		  			<div class="mb-0">
  		  			  	<div class="form-view-name">Short Name</div>
  		  			  	<div class="form-view-value"><?= $project_info['type']; ?></div>
  		  			</div>
  		  		</div>
  		  	</div>
            <div class="hr1"></div>
  		  	<div class="row">
  		  		<div class="col-md-4 col-sm-6 col-xs-12">
  		  			<div class="mb-0">
  		  				<div class="form-view-name">Location</div>	
  		  			  	<div class="form-view-value"><?= $locations_val[$project_info['location']]['name']; ?></div>	  		  				
  					</div>
  		  		</div>
  		  		<div class="col-md-4 col-sm-6 col-xs-12">
  		  			<div class="mb-0">
  		  				<div class="form-view-name">Client</div>
  		  			  	<div class="form-view-value"><?= $clients_val[$project_info['client']]['name']; ?></div>
  					</div>
  		  		</div>
  		  	</div>
            <div class="hr1"></div>
  		  	<div class="row">
  		  		<div class="col-md-4 col-sm-6 col-xs-12">
  		  			<div class="mb-0">
  		  			  	<div class="form-view-name">Project Managament Consultant</div>
  		  			  	<div class="form-view-value"><?= $project_info['pm_c']; ?></div>
  		  			</div>
  		  		</div>
  		  		<div class="col-md-4 col-sm-6 col-xs-12">
  		  			<div class="mb-0">
  		  			  	<div class="form-view-name">Design Engineer Consultant</div>
  		  			  	<div class="form-view-value"><?= $project_info['de_c']; ?></div>
  		  			</div>
  		  		</div>
  		  	</div>
            <div class="hr1"></div>
  		  	<div class="row">
  		  		<div class="col-md-4 col-sm-6 col-xs-12">
	  		  		<div class="mb-0">
	  		  		  	<div class="form-view-name">Notification of Award</div>
  		  			  	<div class="form-view-value"><?= displayDate($project_info['noa']); ?></div>
	  		  		</div>
	  		  	</div>
  		  		<div class="col-md-4 col-sm-6 col-xs-12">
  		  			<div class="mb-0">
  		  			  	<div class="form-view-name">Completion Date</div>
  		  			  	<div class="form-view-value"><?= displayDate($project_info['completion_date']); ?></div>
  		  			</div>
  		  		</div>
  		  		<div class="col-md-4 col-sm-6 col-xs-12">
  		  			<div class="mb-0">
  		  			  	<div class="form-view-name">Extension Date</div>
  		  			  	<div class="form-view-value"><?= displayDate($project_info['extension_date']); ?></div>
  		  			</div>
  		  		</div>
  		  	</div>
            <div class="hr1"></div>
            <div class="row">
                <div class="col-md-6 col-sm-12 col-xs-12">
          		  	<div class="row">
          		  		<div class="col-md-6 col-sm-6 col-xs-12">
          		  			<div class="mb-0">
          		  			  	<div class="form-view-name">Contract Value INR</div>
          		  			  	<div class="form-view-value"><?= isset($project_info['contract_value_inr']) ? displayNumber($project_info['contract_value_inr'],2) : 0; ?></div>
          		  			</div>
          		  		</div>
          		  		<div class="col-md-6 col-sm-6 col-xs-12">
          		  			<div class="mb-0">
          		  			  	<div class="form-view-name">Contract Value</div>
          		  			  	<div class="form-view-value"><?= $currencies[$project_info['currency']]['symbol'].' '.displayNumber($project_info['contract_value'],2); ?></div>
          		  			</div>
          		  		</div>
                    </div>
                    <div class="hr1"></div>
                    <div class="row">
          		  		<div class="col-md-6 col-sm-6 col-xs-12">
          		  			<div class="mb-0">
          		  				<div class="form-view-name">Currency</div>
          		  			  	<div class="form-view-value"><?php echo isset($project_info['currency']) ? $currencies[$project_info['currency']]['name'] : ''; ?></div>
          					</div>
          		  		</div>
          		  		<div class="col-md-6 col-sm-6 col-xs-12">
          		  			<div class="mb-0">
          		  				<div class="form-view-name">Exchange Value</div>
          		  			  	<div class="form-view-value"><?= displayNumber($project_info['ex_rate'],2); ?></div>
          		  			</div>
          		  		</div>
          		  	</div>                    
                </div>
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <div class="bd-callout bd-callout-default m-0 p-2 border-0">
      		  			<div class="row mb-2">
                            <label class="col-sm-6 col-form-label text-end form-view-name">Conversion in INR&nbsp;:</label>
      		  				<?
      		  				$conv_value = round(($project_info['ex_rate'] * $project_info['contract_value']),2);?>
      		  				<label class="col-sm-6 col-form-label text-end form-view-value"><?= displayNumber($conv_value,2); ?></label> 	  		  				
      		  			</div>
      		  			<div class="row mb-2">
      		  				<label class="col-sm-6 col-form-label text-end form-view-name">Total in INR&nbsp;:</label>
      		  				<?
      		  				$total_val = $conv_value + $project_info['contract_value_inr']; ?>
      		  				<label class="col-sm-6 col-form-label text-end form-view-value"><?= displayNumber($total_val,2); ?></label>
      		  			</div>
      		  			<div class="row mb-0">
      		  				<label class="col-sm-6 col-form-label text-end form-view-name">Total INR(in Crs)&nbsp;:</label>
      		  				<? $tot_crs = round(($total_val / 10000000), 2); ?>
      		  				<label class="col-sm-6 col-form-label text-end form-view-value"><?= displayNumber($tot_crs,2); ?></label>
      		  			</div>                        
                    </div>
                </div>
            </div>
            <div class="hr1"></div>
	  		<div class="mb-0">
	  			<label class="form-label">Note</label>
	  			<div><strong><?php echo (isset($project_info['note']) and $project_info['note'] != '') ? $project_info['note'] : "--"; ?></strong></div>
	  		</div>
            <div class="hr1"></div> 
            <!-- <button class="btn btn-success btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFiles" aria-expanded="false" aria-controls="collapseFiles"><i class="bi bi-plus-square"></i>&nbsp;Add File</button>            -->
            <div id="file_upload_body"><?= view('invoice_tracking/project/project_view_file') ?></div>
  	  	</div>
  	  	<div class="modal-footer">
  	  	  	<button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal"><i class="bi bi-x-square"></i>&nbsp;Close</button>
  	  	</div>
  	</div>
</div>