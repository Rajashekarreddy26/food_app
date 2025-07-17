<?php
/**
 * Client details with projects and invoices
 */
?>
<?= $this->extend('template/template_admin'); ?>
<?= $this->section('content'); ?>

<div class="row">	
	<div class="col-md-3 col-sm-12">
		<div class="client-block">
  			<p class="client-name text-center fs-3"><? print $client['name']; ?></p>
		</div>
	</div>
	<div class="col-md-9 col-sm-12">
		<div class="table table-responsive mt-2">
			<table class="table table-bordered table-striped table-centered mb-0">
				<thead class="table-light">
					<tr>
						<th>Catogory</th>
						<th class="text-end">Receivables (Crs)</th>
						<th class="text-end">Received (Crs)</th>
						<th class="text-end">Balance (Crs)</th>
						<th></th>
					</tr>						
				</thead>
				<tbody>
					<?
					$eng_inv_total = $pro_inv_total = $cons_inv_total = $eng_paid_total = $pro_paid_total = $cons_paid_total = $eng_bal_amt = $pro_bal_amt = $cons_bal_amt = $eng_basic = $eng_deds = $eng_paids = $pro_basic = $pro_deds = $pro_paids = $cons_basic = $cons_deds = $cons_paids = 0;
					$inv_proj_sums = $client_inv_sums[] = array();
					if (isset($projects) && !empty($projects)) {
						foreach ($projects as $p_key => $project) {
							if (isset($inv_totals[$p_key])) {
								if (isset($inv_categories) && !empty($inv_categories)) {
									foreach ($inv_categories as $key => $category) {

										if (isset($inv_totals[$p_key][$key])) {
											if ($key == 1) {
												$eng_base_amt = (isset($inv_totals[$p_key][$key]['base_total']) && !empty($inv_totals[$p_key][$key]['base_total'])) ? $inv_totals[$p_key][$key]['base_total'] : 0;
												$eng_ded_amt = (isset($inv_totals[$p_key][$key]['deductions']) && !empty($inv_totals[$p_key][$key]['deductions'])) ? $inv_totals[$p_key][$key]['deductions'] : 0;
												$eng_paid_total = (isset($inv_totals[$p_key][$key]['paid_total']) && !empty($inv_totals[$p_key][$key]['paid_total'])) ? $inv_totals[$p_key][$key]['paid_total'] : 0;
												$eng_inv_total = $eng_base_amt - $eng_ded_amt;
												$eng_bal_amt = $eng_inv_total - $eng_paid_total;

												$inv_proj_sums[$p_key][$key]['invoice_amt'] = $eng_inv_total;
												$inv_proj_sums[$p_key][$key]['paid_amt'] = $eng_paid_total;
												$inv_proj_sums[$p_key][$key]['balance_amt'] = $eng_bal_amt;

												$eng_basic += $eng_base_amt;
												$eng_deds += $eng_ded_amt;
												$eng_paids += $eng_paid_total;


											}
											elseif ($key == 2) {
												$pro_base_amt = (isset($inv_totals[$p_key][$key]['base_total']) && !empty($inv_totals[$p_key][$key]['base_total'])) ? $inv_totals[$p_key][$key]['base_total'] : 0;
												$pro_ded_amt = (isset($inv_totals[$p_key][$key]['deductions']) && !empty($inv_totals[$p_key][$key]['deductions'])) ? $inv_totals[$p_key][$key]['deductions'] : 0;
												$pro_paid_total = (isset($inv_totals[$p_key][$key]['paid_total']) && !empty($inv_totals[$p_key][$key]['paid_total'])) ? $inv_totals[$p_key][$key]['paid_total'] : 0;
												$pro_inv_total = $pro_base_amt - $pro_ded_amt;
												$pro_bal_amt = $pro_inv_total - $pro_paid_total;

												$inv_proj_sums[$p_key][$key]['invoice_amt'] = $pro_inv_total;
												$inv_proj_sums[$p_key][$key]['paid_amt'] = $pro_paid_total;
												$inv_proj_sums[$p_key][$key]['balance_amt'] = $pro_bal_amt;

												$pro_basic += $pro_base_amt;
												$pro_deds += $pro_ded_amt;
												$pro_paids += $pro_paid_total;

											}
											elseif ($key == 3) {
												$cons_base_amt = (isset($inv_totals[$p_key][$key]['base_total']) && !empty($inv_totals[$p_key][$key]['base_total'])) ? $inv_totals[$p_key][$key]['base_total'] : 0;
												$cons_ded_amt = (isset($inv_totals[$p_key][$key]['deductions']) && !empty($inv_totals[$p_key][$key]['deductions'])) ? $inv_totals[$p_key][$key]['deductions'] : 0;
												$cons_paid_total = (isset($inv_totals[$p_key][$key]['paid_total']) && !empty($inv_totals[$p_key][$key]['paid_total'])) ? $inv_totals[$p_key][$key]['paid_total'] : 0;
												$cons_inv_total = $cons_base_amt - $cons_ded_amt;
												$cons_bal_amt = $cons_inv_total - $cons_paid_total;

												$inv_proj_sums[$p_key][$key]['invoice_amt'] = $cons_inv_total;
												$inv_proj_sums[$p_key][$key]['paid_amt'] = $cons_paid_total;
												$inv_proj_sums[$p_key][$key]['balance_amt'] = $cons_bal_amt;

												$cons_basic += $cons_base_amt;
												$cons_deds += $cons_ded_amt;
												$cons_paids += $cons_paid_total;
											}
										}
							 		}
							 	}
							} 
						}
					}

					if (isset($inv_categories) && !empty($inv_categories)) {
						foreach ($inv_categories as $key => $category) {
							if ($key == 1) {
								$client_inv_sums[$key]['base_total'] = $eng_basic;
								$client_inv_sums[$key]['deductions'] = $eng_deds;
								$client_inv_sums[$key]['paid_total'] = $eng_paids;
							}
							elseif ($key == 2) {
								$client_inv_sums[$key]['base_total'] = $pro_basic;
								$client_inv_sums[$key]['deductions'] = $pro_deds;
								$client_inv_sums[$key]['paid_total'] = $pro_paids;
							}
							elseif ($key == 3) {
								$client_inv_sums[$key]['base_total'] = $cons_basic;
								$client_inv_sums[$key]['deductions'] = $cons_deds;
								$client_inv_sums[$key]['paid_total'] = $cons_paids;
							}
						}
					}

					$total_basic_amt = $total_ded_amt = $total_receivable_amt = $total_paid_amt = $total_balance = $total_receivable_in_cr = $total_paid_in_cr = $total_balance_in_cr = 0;
					if (isset($inv_categories) && !empty($inv_categories)) {
						foreach ($inv_categories as $key => $category) {
							$base_total = (isset($client_inv_sums[$key]['base_total']) && !empty($client_inv_sums[$key]['base_total'])) ? $client_inv_sums[$key]['base_total'] : 0;
							$ded_totals = (isset($client_inv_sums[$key]['deductions']) && !empty($client_inv_sums[$key]['deductions'])) ? $client_inv_sums[$key]['deductions'] : 0;
							$receivables = $base_total - $ded_totals;
							$received_amt = (isset($client_inv_sums[$key]['paid_total']) && !empty($client_inv_sums[$key]['paid_total'])) ? $client_inv_sums[$key]['paid_total'] : 0;
							$balances = $receivables - $received_amt;

							$percent = ((isset($receivables) && $receivables > 0) && (isset($received_amt) && $received_amt > 0)) ? ($received_amt/$receivables)*100 : 0;
							$percent_val = (isset($percent) && !empty($percent)) ? round($percent,2) : 0;

							$total_receivable_amt += $receivables;
							$total_paid_amt += $received_amt;
							$total_balance += $balances;

							$receivables_in_cr = (isset($receivables) && $receivables > 0) ? $receivables/10000000 : 0;
							$received_in_cr = (isset($received_amt) && $received_amt > 0) ? $received_amt/10000000 : 0;
							$balance_in_cr = (isset($balances) && $balances > 0) ? $balances/10000000 : 0;

							$total_receivable_in_cr = (isset($total_receivable_amt) && $total_receivable_amt > 0) ? $total_receivable_amt/10000000 : 0;
							$total_paid_in_cr = (isset($total_paid_amt) && $total_paid_amt > 0) ? $total_paid_amt/10000000 : 0;
							$total_balance_in_cr = (isset($total_balance) && $total_balance > 0) ? $total_balance/10000000 : 0; 


							?>
							<tr>
								<td><strong><? print $category; ?></strong></td>
								<td class="text-end"><? print displayMoney($receivables_in_cr,4); ?></td>
								<td class="text-end"><? print displayMoney($received_in_cr,4); ?></td>
								<td class="text-end"><? print displayMoney($balance_in_cr,4); ?></td>
								<td>
									<div class="progress " role="progressbar" aria-label="Success example" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                		<div class="progress-bar bg-success" style="width: <? echo $percent_val; ?>%;"><? echo $percent_val; ?>%</div>
                        			</div>
                        		</td>
							</tr>
						<?
						}
					} 
					?>
					<tr>
						<td>Totals(in Crs)</td>
						<td class="text-end"><? print displayMoney($total_receivable_in_cr,4); ?></td>
						<td class="text-end"><? print displayMoney($total_paid_in_cr,4); ?></td>
						<td class="text-end"><? print displayMoney($total_balance_in_cr,4); ?></td>
						<td></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
<div class="sub-title mb-2">Project Details&nbsp;:</div>
<div class="table table-responsive freeze-table">
	<table class="table table-bordered table-hover table-striped table-condensed">
		<thead>
			<tr class="align-middle">
				<th nowrap rowspan="2" width="1%" class="text-center">S.No.</th>
				<th nowrap rowspan="2">Code</th>
				<th nowrap rowspan="2">Name</th>
				<th nowrap rowspan="2">Location</th>
				<th nowrap rowspan="2" class="text-end">Total in INR</th>
				<th nowrap rowspan="2" class="text-end">Contract Value(in Crs)</th>
				<th nowrap colspan="3" class="text-center">Receivables(in Crs)</th>
				<th nowrap colspan="3" class="text-center">Received(in Crs)</th>
				<th nowrap colspan="3" class="text-center">Balance(in Crs)</th>
			</tr>
			<tr class="align-middle">
				<th nowrap class="text-end">Engineering</th>
				<th nowrap class="text-end">Procurement</th>
				<th nowrap class="text-end">Construction</th>
				<th nowrap class="text-end">Engineering</th>
				<th nowrap class="text-end">Procurement</th>
				<th nowrap class="text-end">Construction</th>
				<th nowrap class="text-end">Engineering</th>
				<th nowrap class="text-end">Procurement</th>
				<th nowrap class="text-end">Construction</th>
			</tr>
		</thead>
		<tbody>
		<?
		$i = 1;
		if (isset($projects) && !empty($projects)) {
			foreach ($projects as $p_key => $project) { 
				$conversion_inr = $project['ex_rate']*$project['contract_value'];
				$total_inr = $project['contract_value_inr']+$conversion_inr;
				$amt_in_cr = $total_inr/10000000; 

				$proj_eng_inv = (isset($inv_proj_sums[$p_key][1]['invoice_amt'])) ? $inv_proj_sums[$p_key][1]['invoice_amt'] : 0;
				$proj_pro_inv = (isset($inv_proj_sums[$p_key][2]['invoice_amt'])) ? $inv_proj_sums[$p_key][2]['invoice_amt'] : 0;
				$proj_con_inv = (isset($inv_proj_sums[$p_key][3]['invoice_amt'])) ? $inv_proj_sums[$p_key][3]['invoice_amt'] : 0;
				$proj_eng_paid = (isset($inv_proj_sums[$p_key][1]['paid_amt'])) ? $inv_proj_sums[$p_key][1]['paid_amt'] : 0;
				$proj_pro_paid = (isset($inv_proj_sums[$p_key][2]['paid_amt'])) ? $inv_proj_sums[$p_key][2]['paid_amt'] : 0;
				$proj_con_paid = (isset($inv_proj_sums[$p_key][3]['paid_amt'])) ? $inv_proj_sums[$p_key][3]['paid_amt'] : 0;
				$proj_eng_bal = (isset($inv_proj_sums[$p_key][1]['balance_amt'])) ? $inv_proj_sums[$p_key][1]['balance_amt'] : 0;
				$proj_pro_bal = (isset($inv_proj_sums[$p_key][2]['balance_amt'])) ? $inv_proj_sums[$p_key][2]['balance_amt'] : 0;
				$proj_con_bal = (isset($inv_proj_sums[$p_key][3]['balance_amt'])) ? $inv_proj_sums[$p_key][3]['balance_amt'] : 0;


				$proj_eng_inv_in_cr = (isset($proj_eng_inv) && $proj_eng_inv > 0) ? $proj_eng_inv/10000000 : 0;
				$proj_pro_inv_in_cr = (isset($proj_pro_inv) && $proj_pro_inv > 0) ? $proj_pro_inv/10000000 :0;
				$proj_con_inv_in_cr = (isset($proj_con_inv) && $proj_con_inv > 0) ? $proj_con_inv/10000000 : 0;
				$proj_eng_paid_in_cr = (isset($proj_eng_paid) && $proj_eng_paid > 0) ? $proj_eng_paid/10000000 : 0;
				$proj_pro_paid_in_cr = (isset($proj_pro_paid) && $proj_pro_paid > 0) ? $proj_pro_paid/10000000 : 0;
				$proj_con_paid_in_cr = (isset($proj_con_paid) && $proj_con_paid > 0) ? $proj_con_paid/10000000 : 0;
				$proj_eng_bal_in_cr = (isset($proj_eng_bal) && $proj_eng_bal > 0) ? $proj_eng_bal/10000000 : 0;
				$proj_pro_bal_in_cr = (isset($proj_pro_bal) && $proj_pro_bal > 0) ? $proj_pro_bal/10000000 : 0;
				$proj_con_bal_in_cr = (isset($proj_con_bal) && $proj_con_bal > 0) ? $proj_con_bal/10000000 : 0;

				?>
				<tr>
					<td nowrap class="text-center"><?= $i++ ?></td>
					<td nowrap><?= $project['code'] ?></td>
					<td nowrap><a href="javascript:void(0)" onclick="viewProjectInvoices(<?= $project['id'] ?>)"><?= $project['name'] ?></a></td>
					<td nowrap><?= (isset($locations[$project['location']]) && !empty($locations[$project['location']])) ? $locations[$project['location']]['name'] : "-" ?></td>
					<td nowrap class="text-end"><?= displayNumber($total_inr) ?></td>
					<td nowrap class="text-end"><?= displayNumber($amt_in_cr,2) ?></td>
					<td nowrap class="text-end"><? print displayNumber($proj_eng_inv_in_cr,4); ?></td>
					<td nowrap class="text-end"><? print displayNumber($proj_pro_inv_in_cr,4); ?></td>
					<td nowrap class="text-end"><? print displayNumber($proj_con_inv_in_cr,4); ?></td>
					<td nowrap class="text-end"><? print displayNumber($proj_eng_paid_in_cr,4); ?></td>
					<td nowrap class="text-end"><? print displayNumber($proj_pro_paid_in_cr,4); ?></td>
					<td nowrap class="text-end"><? print displayNumber($proj_con_paid_in_cr,4); ?></td>
					<td nowrap class="text-end"><? print displayNumber($proj_eng_bal_in_cr,4); ?></td>
					<td nowrap class="text-end"><? print displayNumber($proj_pro_bal_in_cr,4); ?></td>
					<td nowrap class="text-end"><? print displayNumber($proj_con_bal_in_cr,4); ?></td>
				</tr>
			<?
			}
		}
		else { 
			?>
			<tr>
				<td colspan="15"><div class="alert alert-warning">No Records Found</div></td>
			</tr>
		<?
		}
		?>
		</tbody>
	</table>
</div>
<div class="sub-title mb-2">Invoice Details&nbsp;:</div>
<ul class="nav nav-tabs" id="myTab" role="tablist">
  	<li class="nav-item" role="presentation">
    	<button class="nav-link active" id="engineering-tab" data-bs-toggle="tab" data-bs-target="#engineering" type="button" role="tab" aria-controls="engineering" aria-selected="true"><i class="bi bi-person-gear"></i>&nbsp;Engineering</button>
  	</li>
  	<li class="nav-item" role="presentation">
    	<button class="nav-link" id="procurement-tab" data-bs-toggle="tab" data-bs-target="#procurement" type="button" role="tab" aria-controls="procurement" aria-selected="false"><i class="bi bi-box-seam"></i>&nbsp;Procurement</button>
  	</li>
  	<li class="nav-item" role="presentation">
    	<button class="nav-link" id="construction-tab" data-bs-toggle="tab" data-bs-target="#construction" type="button" role="tab" aria-controls="construction" aria-selected="false"><i class="bi bi-cone-striped"></i>&nbsp;Construction</button>
  	</li>
</ul>
<div class="tab-content" id="myTabContent">
  	<div class="tab-pane fade show active" id="engineering" role="tabpanel" aria-labelledby="engineering-tab">
		<div class="table-responsive freeze-table2 mt-2">
	        <table class="table table-bordered table-hover table-striped table-condensed">
	            <thead>
	                <tr class="align-middle">
	                    <th nowrap rowspan="2" width="1%" class="text-center">S.No.</th>
	                    <th nowrap rowspan="2">Invoice No.</th>
	                    <th nowrap rowspan="2">Date</th>
	                    <th nowrap rowspan="2">Project</th>
	                    <!-- <th rowspan="2">Client</th> -->
	                    <th nowrap rowspan="2">Type</th>
	                    <th nowrap colspan="4" class="text-center">Invoice Value</th>
	                    <th nowrap colspan="6" class="text-center">Deductions</th>
	                    <th nowrap rowspan="2" class="text-end">Total</th>
	                    <th nowrap rowspan="2" class="text-end">Received</th>
	                    <th nowrap rowspan="2" class="text-end">Balance</th>
	                </tr>
	                <tr class="align-middle">
	                    <th nowrap class="text-end">Basic</th>
	                    <th nowrap class="text-end">SGST</th>
	                    <th nowrap class="text-end">CGST</th>
	                    <th nowrap class="text-end">Total</th>
	                    <th nowrap class="text-end">TDS</th>
	                    <th nowrap class="text-end" nowrap="">TDS-SGST</th>
	                    <th nowrap class="text-end" nowrap="">TDS-CGST</th>
	                    <th nowrap class="text-end" nowrap="">Labour Cess</th>
	                    <th nowrap class="text-end">Others</th>
	                    <th nowrap class="text-end">Total D</th>
	                </tr>
	            </thead>
	            <tbody>
	            	<?
					$i = 1;
					if (isset($invoices[1]) && !empty($invoices[1])) {
						foreach ($invoices[1] as $key => $invoice) { 
							$basic = (isset($invoice['basic']) && !empty($invoice['basic'])) ? $invoice['basic'] : 0;
							$basic_sgst = (isset($invoice['sgst']) && !empty($invoice['sgst'])) ? $invoice['sgst'] : 0;
							$basic_cgst = (isset($invoice['cgst']) && !empty($invoice['cgst'])) ? $invoice['cgst'] : 0;
							$basic_total = (isset($invoice['total']) && !empty($invoice['total'])) ? $invoice['total'] : 0;
							$tds = (isset($invoice['tds']) && !empty($invoice['tds'])) ? $invoice['tds'] : 0;
							$tds_sgst = (isset($invoice['tds_sgst']) && !empty($invoice['tds_sgst'])) ? $invoice['tds_sgst'] : 0;
							$tds_cgst = (isset($invoice['tds_cgst']) && !empty($invoice['tds_cgst'])) ? $invoice['tds_cgst'] : 0;
							$lbr_cess = (isset($invoice['labour_cess']) && !empty($invoice['labour_cess'])) ? $invoice['labour_cess'] : 0;
							$other_ded = (isset($invoice['other_deductions']) && !empty($invoice['other_deductions'])) ? $invoice['other_deductions'] : 0;
							$total_ded = $tds+$tds_sgst+$tds_cgst+$lbr_cess+$other_ded;
							$g_total = $basic_total - $total_ded;
							$total_received = (isset($invoice['total_received']) && !empty($invoice['total_received'])) ? $invoice['total_received'] : 0;
							$balance_amt = $g_total - $total_received;

	            	 ?>
	            	 <tr>
	            	 	<td nowrap class="text-center"><?= $i++ ?></td>
	            	 	<td nowrap><a href="javascript:viewInvoice(<?= $invoice['id'] ?>)"><?= $invoice['inv_number'] ?></a></td>
	            	 	<td nowrap><?= displayDate($invoice['inv_date']) ?></td>
	            	 	<td nowrap><?= (isset($projects[$invoice['project_id']]) && !empty($projects[$invoice['project_id']])) ? $projects[$invoice['project_id']]['name'] : "-" ?></td>
	            	 	<!-- <td><?= $client['name'] ?></td> -->
	            	 	<td nowrap><?= (isset($inv_categories[$invoice['inv_category']]) && !empty($inv_categories[$invoice['inv_category']])) ? $inv_categories[$invoice['inv_category']] : "-"?></td>
	            	 	<td nowrap class="text-end"><?= displayNumber($basic) ?></td>
	            	 	<td nowrap class="text-end"><?= displayNumber($basic_sgst) ?></td>
	            	 	<td nowrap class="text-end"><?= displayNumber($basic_cgst) ?></td>
	            	 	<td nowrap class="text-end"><?= displayNumber($basic_total) ?></td>
	            	 	<td nowrap class="text-end"><?= displayNumber($tds) ?></td>
	            	 	<td nowrap class="text-end"><?= displayNumber($tds_sgst) ?></td>
	            	 	<td nowrap class="text-end"><?= displayNumber($tds_cgst) ?></td>
	            	 	<td nowrap class="text-end"><?= displayNumber($lbr_cess) ?></td>
	            	 	<td nowrap class="text-end"><?= displayNumber($other_ded) ?></td>
	            	 	<td nowrap class="text-end"><?= displayNumber($total_ded) ?></td>
	            	 	<td nowrap class="text-end"><?= displayNumber($g_total) ?></td>
	            	 	<td nowrap class="text-end"><?= displayNumber($total_received) ?></td>
	            	 	<td nowrap class="text-end"><?= displayNumber($balance_amt) ?></td>
	            	 </tr>
	            	 <?
		            	}
		            }
		            else { 
						?>
						<tr>
							<td colspan="18"><div class="alert alert-warning">No Records Found</div></td>
						</tr>
					<?
					}
					?>
	            </tbody>
	        </table>
		</div>
  	</div>
  	<div class="tab-pane fade" id="procurement" role="tabpanel" aria-labelledby="procurement-tab">
  		<div class="table-responsive freeze-table3 mt-2">
	        <table class="table table-bordered table-hover table-striped table-condensed">
	            <thead>
	                <tr class="align-middle">
	                    <th nowrap rowspan="2" width="1%" class="text-center">S.No.</th>
	                    <th nowrap rowspan="2">Invoice No.</th>
	                    <th nowrap rowspan="2">Date</th>
	                    <th nowrap rowspan="2">Project</th>
	                    <!-- <th rowspan="2">Client</th> -->
	                    <th nowrap rowspan="2">Type</th>
	                    <th nowrap colspan="4" class="text-center">Invoice Value</th>
	                    <th nowrap colspan="6" class="text-center">Deductions</th>
	                    <th nowrap rowspan="2" class="text-end">Total</th>
	                    <th nowrap rowspan="2" class="text-end">Received</th>
	                    <th nowrap rowspan="2" class="text-end">Balance</th>
	                </tr>
	                <tr class="align-middle">
	                    <th nowrap class="text-end">Basic</th>
	                    <th nowrap class="text-end">SGST</th>
	                    <th nowrap class="text-end">CGST</th>
	                    <th nowrap class="text-end">Total</th>
	                    <th nowrap class="text-end">TDS</th>
	                    <th nowrap class="text-end">TDS-SGST</th>
	                    <th nowrap class="text-end">TDS-CGST</th>
	                    <th nowrap class="text-end">Labour Cess</th>
	                    <th nowrap class="text-end">Others</th>
	                    <th nowrap class="text-end">Total D</th>
	                </tr>
	            </thead>
	            <tbody>
	            	<?
					$i = 1;
					if (isset($invoices[2]) && !empty($invoices[2])) {
						foreach ($invoices[2] as $key => $invoice) { 
							$basic = (isset($invoice['basic']) && !empty($invoice['basic'])) ? $invoice['basic'] : 0;
							$basic_sgst = (isset($invoice['sgst']) && !empty($invoice['sgst'])) ? $invoice['sgst'] : 0;
							$basic_cgst = (isset($invoice['cgst']) && !empty($invoice['cgst'])) ? $invoice['cgst'] : 0;
							$basic_total = (isset($invoice['total']) && !empty($invoice['total'])) ? $invoice['total'] : 0;
							$tds = (isset($invoice['tds']) && !empty($invoice['tds'])) ? $invoice['tds'] : 0;
							$tds_sgst = (isset($invoice['tds_sgst']) && !empty($invoice['tds_sgst'])) ? $invoice['tds_sgst'] : 0;
							$tds_cgst = (isset($invoice['tds_cgst']) && !empty($invoice['tds_cgst'])) ? $invoice['tds_cgst'] : 0;
							$lbr_cess = (isset($invoice['labour_cess']) && !empty($invoice['labour_cess'])) ? $invoice['labour_cess'] : 0;
							$other_ded = (isset($invoice['other_deductions']) && !empty($invoice['other_deductions'])) ? $invoice['other_deductions'] : 0;
							$total_ded = $tds+$tds_sgst+$tds_cgst+$lbr_cess+$other_ded;
							$g_total = $basic_total - $total_ded;
							$total_received = (isset($invoice['total_received']) && !empty($invoice['total_received'])) ? $invoice['total_received'] : 0;
							$balance_amt = $g_total - $total_received;
	            	 ?>
	            	 <tr>
	            	 	<td nowrap class="text-center"><?= $i++ ?></td>
	            	 	<td nowrap><a href="javascript:viewInvoice(<?= $invoice['id'] ?>)"><?= $invoice['inv_number'] ?></a></td>
	            	 	<td nowrap><?= displayDate($invoice['inv_date']) ?></td>
	            	 	<td nowrap><?= (isset($projects[$invoice['project_id']]) && !empty($projects[$invoice['project_id']])) ? $projects[$invoice['project_id']]['name'] : "-" ?></td>
	            	 	<!-- <td><?= $client['name'] ?></td> -->
	            	 	<td nowrap><?= (isset($inv_categories[$invoice['inv_category']]) && !empty($inv_categories[$invoice['inv_category']])) ? $inv_categories[$invoice['inv_category']] : "-"?></td>
	            	 	<td nowrap class="text-end"><?= displayNumber($basic) ?></td>
	            	 	<td nowrap class="text-end"><?= displayNumber($basic_sgst) ?></td>
	            	 	<td nowrap class="text-end"><?= displayNumber($basic_cgst) ?></td>
	            	 	<td nowrap class="text-end"><?= displayNumber($basic_total) ?></td>
	            	 	<td nowrap class="text-end"><?= displayNumber($tds) ?></td>
	            	 	<td nowrap class="text-end"><?= displayNumber($tds_sgst) ?></td>
	            	 	<td nowrap class="text-end"><?= displayNumber($tds_cgst) ?></td>
	            	 	<td nowrap class="text-end"><?= displayNumber($lbr_cess) ?></td>
	            	 	<td nowrap class="text-end"><?= displayNumber($other_ded) ?></td>
	            	 	<td nowrap class="text-end"><?= displayNumber($total_ded) ?></td>
	            	 	<td nowrap class="text-end"><?= displayNumber($g_total) ?></td>
	            	 	<td nowrap class="text-end"><?= displayNumber($total_received) ?></td>
	            	 	<td nowrap class="text-end"><?= displayNumber($balance_amt) ?></td>
	            	 </tr>
	            	 <?
		            	}
		            }
		            else { 
						?>
						<tr>
							<td colspan="18"><div class="alert alert-warning">No Records Found</div></td>
						</tr>
					<?
					}
					?>
	            </tbody>
	        </table>
		</div>
  	</div>
  	<div class="tab-pane fade" id="construction" role="tabpanel" aria-labelledby="construction-tab">
  		<div class="table-responsive freeze-table4 mt-2">
	        <table class="table table-bordered table-hover table-striped table-condensed">
	            <thead>
	                <tr class="align-middle">
	                    <th nowrap rowspan="2" width="1%" class="text-center">S.No.</th>
	                    <th nowrap rowspan="2">Invoice No.</th>
	                    <th nowrap rowspan="2">Date</th>
	                    <th nowrap rowspan="2">Project</th>
	                    <!-- <th rowspan="2">Client</th> -->
	                    <th nowrap rowspan="2">Type</th>
	                    <th nowrap colspan="4" class="text-center">Invoice Value</th>
	                    <th nowrap colspan="6" class="text-center">Deductions</th>
	                    <th nowrap rowspan="2" class="text-end">Total</th>
	                    <th nowrap rowspan="2" class="text-end">Received</th>
	                    <th nowrap rowspan="2" class="text-end">Balance</th>
	                </tr>
	                <tr class="align-middle">
	                    <th nowrap class="text-end">Basic</th>
	                    <th nowrap class="text-end">SGST</th>
	                    <th nowrap class="text-end">CGST</th>
	                    <th nowrap class="text-end">Total</th>
	                    <th nowrap class="text-end">TDS</th>
	                    <th nowrap class="text-end">TDS-SGST</th>
	                    <th nowrap class="text-end">TDS-CGST</th>
	                    <th nowrap class="text-end">Labour Cess</th>
	                    <th nowrap class="text-end">Others</th>
	                    <th nowrap class="text-end">Total D</th>
	                </tr>
	            </thead>
	            <tbody>
	            	<?
					$i = 1;
					if (isset($invoices[3]) && !empty($invoices[3])) {
						foreach ($invoices[3] as $key => $invoice) { 
							$basic = (isset($invoice['basic']) && !empty($invoice['basic'])) ? $invoice['basic'] : 0;
							$basic_sgst = (isset($invoice['sgst']) && !empty($invoice['sgst'])) ? $invoice['sgst'] : 0;
							$basic_cgst = (isset($invoice['cgst']) && !empty($invoice['cgst'])) ? $invoice['cgst'] : 0;
							$basic_total = (isset($invoice['total']) && !empty($invoice['total'])) ? $invoice['total'] : 0;
							$tds = (isset($invoice['tds']) && !empty($invoice['tds'])) ? $invoice['tds'] : 0;
							$tds_sgst = (isset($invoice['tds_sgst']) && !empty($invoice['tds_sgst'])) ? $invoice['tds_sgst'] : 0;
							$tds_cgst = (isset($invoice['tds_cgst']) && !empty($invoice['tds_cgst'])) ? $invoice['tds_cgst'] : 0;
							$lbr_cess = (isset($invoice['labour_cess']) && !empty($invoice['labour_cess'])) ? $invoice['labour_cess'] : 0;
							$other_ded = (isset($invoice['other_deductions']) && !empty($invoice['other_deductions'])) ? $invoice['other_deductions'] : 0;
							$total_ded = $tds+$tds_sgst+$tds_cgst+$lbr_cess+$other_ded;
							$g_total = $basic_total - $total_ded;
							$total_received = (isset($invoice['total_received']) && !empty($invoice['total_received'])) ? $invoice['total_received'] : 0;
							$balance_amt = $g_total - $total_received;
	            	 ?>
	            	 <tr>
	            	 	<td nowrap class="text-center"><?= $i++ ?></td>
	            	 	<td nowrap><a href="javascript:viewInvoice(<?= $invoice['id'] ?>)"><?= $invoice['inv_number'] ?></a></td>
	            	 	<td nowrap><?= displayDate($invoice['inv_date']) ?></td>
	            	 	<td nowrap><?= (isset($projects[$invoice['project_id']]) && !empty($projects[$invoice['project_id']])) ? $projects[$invoice['project_id']]['name'] : "-" ?></td>
	            	 	<?/*<td><?= $client['name'] ?></td> */?>
	            	 	<td nowrap><?= (isset($inv_categories[$invoice['inv_category']]) && !empty($inv_categories[$invoice['inv_category']])) ? $inv_categories[$invoice['inv_category']] : "-"?></td>
	            	 	<td nowrap class="text-end"><?= displayNumber($basic) ?></td>
	            	 	<td nowrap class="text-end"><?= displayNumber($basic_sgst) ?></td>
	            	 	<td nowrap class="text-end"><?= displayNumber($basic_cgst) ?></td>
	            	 	<td nowrap class="text-end"><?= displayNumber($basic_total) ?></td>
	            	 	<td nowrap class="text-end"><?= displayNumber($tds) ?></td>
	            	 	<td nowrap class="text-end"><?= displayNumber($tds_sgst) ?></td>
	            	 	<td nowrap class="text-end"><?= displayNumber($tds_cgst) ?></td>
	            	 	<td nowrap class="text-end"><?= displayNumber($lbr_cess) ?></td>
	            	 	<td nowrap class="text-end"><?= displayNumber($other_ded) ?></td>
	            	 	<td nowrap class="text-end"><?= displayNumber($total_ded) ?></td>
	            	 	<td nowrap class="text-end"><?= displayNumber($g_total) ?></td>
	            	 	<td nowrap class="text-end"><?= displayNumber($total_received) ?></td>
	            	 	<td nowrap class="text-end"><?= displayNumber($balance_amt) ?></td>
	            	 </tr>
	            	 <?
		            	}
		            }
		            else { 
						?>
						<tr>
							<td colspan="18"><div class="alert alert-warning">No Records Found</div></td>
						</tr>
					<?
					}
					?>
	            </tbody>
	        </table>
		</div>
  	</div>
</div>
<script type="text/javascript">
	$(function() {
        $('.freeze-table').freezeTable({freezeColumn: true, columnNum: 2});
        $('.freeze-table2').freezeTable({freezeColumn: true, columnNum: 2});
        $('.freeze-table3').freezeTable({freezeColumn: true, columnNum: 2});
        $('.freeze-table4').freezeTable({freezeColumn: true, columnNum: 2});
        // Reset the freeze for the tab tables
        $('.nav-item').click(function() {
        	$('.freeze-table').freezeTable('update');
	        $('.freeze-table2').freezeTable('update');
	        $('.freeze-table3').freezeTable('update');
	        $('.freeze-table4').freezeTable('update');
        });
    });
</script>

<?= $this->endsection(); ?>