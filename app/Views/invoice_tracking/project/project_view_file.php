<?php
/**
 * Project File Upload
 */ 

// File types array
if(isset($file_types)) {
	foreach($file_types as $key => $file_type1){
		$filesType[$file_type1['id']] = $file_type1;
	}
}
$project_id = (set_value('project_id')) ? set_value('project_id') : $project_info['id'];
$col_status = isset($file_show_error) ? $file_show_error : 0;
?>
<div class="clearfix mb-2">
	<div class="float-start">
		<div class="sub-title">
            Project Files
        </div>
	</div>
	<div class="float-end">
	 	<button class="btn btn-success btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFiles" aria-expanded="true" aria-controls="collapseFiles"><i class="bi bi-plus-square"></i>&nbsp;Add File</button>		
	</div>
</div>
<!-- collapsable -->
<div class="collapse <? if($col_status) echo 'show'; ?>" id="collapseFiles">
	<form class="form" method="post" name="add-proj-fil" enctype="multipart/form-data">
		<div class="card mb-0">
			<div class="card-body">
				<div class="row">
					<div class="col-md-4 col-sm-6 col-xs-12">
						<label class="form-label mb-0">File Type</label>
						<select class="form-select form-select-sm" name="file_type" id="file_type">
							<option value="">Select</option>
							<?
							foreach ($file_types as $f_t => $file_type) {
								?><option value="<?= $file_type['id'] ?>"<? if($file_type['id'] == set_value('file_type')){ echo "selected";}?>><?= $file_type['name'] ?></option><?
							}
							?>
						</select>
						<span class="text-danger"><small><?= validation_show_error('file_type') ?></small></span>
					</div>
					<div class="col-md-4 col-sm-6 col-xs-12">
						<label class="form-label mb-0">File Upload</label>
						<input class="form-control form-control-sm" type="file" id="file"/>
						<small>Allowed file types (pdf, docx, doc, png, jpg).</small>
                        <small>Maximum file size 20MB.</small>
						<span class="text-danger"><small><?= validation_show_error('file') ?></small></span>
					</div>
					<div class="col-md-4 col-sm-6 col-xs-12">
						<label class="form-label mb-0">&nbsp;</label>
						<input type="hidden" name="project_id" id="project_id" value="<?= $project_id ?>">
			  	  		<div><button type="button" onclick="uploadProjectFile()" class="btn btn-success btn-sm"><i class="bi bi-plus-square"></i>&nbsp;Upload File</button></div>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
<!-- collapsable -->
<div class="table table-responsive mt-2">
	<table class="table table-bordered table-hover table-striped table-sm">
		<thead>
			<tr>
				<th width="1%" class="text-center">S.No.</th>
				<th class="text-center" nowrap>File Type</th>
				<th nowrap>File</th>
				<th nowrap>Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php 	
			if($project_files) {
				$i = 1;
				foreach ($project_files as $p_key => $project_file) {
				 	?>
					<tr id="pf<?= $project_file['id'] ?>">
						<td class="text-center"><?= $i++; ?></td>
						<td class="text-center"><?= $filesType[$project_file['file_type']]['name']; ?></td>
						<td><a href="<? echo WEBROOT; ?>files/project/<? echo $project_file['file']; ?>" target="_blank" class="btn btn-sm btn-primary" title="<?= $project_file['file'] ?>"><i class="bi bi-file-earmark-arrow-down"></i></a></td>
						<td>
							<button class="btn btn-danger btn-sm" id="files_delete" onclick="deleteProjectFile(<?= $project_file['id']; ?>)" title="delete"><i class="bi bi-trash"></i></button></li>
						</td>
					</tr>
					<?
				}
			}
			else {
				?>
			<tr>
				<td colspan="4"><div class="alert alert-warning">No Records Found</div></td>
			</tr>
		<? } ?>
		</tbody>
	</table>
</div>