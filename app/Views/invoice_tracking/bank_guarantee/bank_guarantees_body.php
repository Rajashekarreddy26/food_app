<?php
/**
 * Invoice tracking
 * Bank guarantees body
 */
$arrow = ($params['sort_order'] == 'desc') ? '<i class="bi bi-arrow-down"></i>' : '<i class="bi bi-arrow-up"></i>';
$sort_order_alt = ($params['sort_order'] == "desc") ? "asc" : "desc";
$sort_order = ($params['sort_order'] == "desc") ? "desc" : "asc";
$sortby = $params['sortby'];
$rows = (isset($params['rows']) and !empty($params['rows'])) ? $params['rows'] : 20;
$pageno = (isset($params['pageno']) and !empty($params['pageno'])) ? $params['pageno'] : 1;
$tRecords = (isset($params['tRecords']) and !empty($params['tRecords'])) ? $params['tRecords'] : 0;
$keywords = (isset($params['keywords']) and !empty($params['keywords'])) ? $params['keywords'] : "";
$exp_val = (isset($params['exp_status']) and !empty($params['exp_status'])) ? $params['exp_status'] : "";
$project_val = (isset($params['project']) and !empty($params['project'])) ? $params['project'] : "";
$total_pages = ceil($tRecords/$rows);
$i = (($pageno-1)*$rows)+1;
?>
<div class="clearfix">
    <div class="float-start d-flex align-items-center">
        <div class="me-1">
            <label class="form-label mb-0">Search&nbsp;:&nbsp;</label>
            <input class="form-control form-control-sm" type="text" name="keywords" id="keywords" placeholder="Search here..." value="<?= $keywords ?>">
        </div>
        <div class="me-1">
            <label class="form-label mb-0">Expiry Status&nbsp;:&nbsp;</label>
            <select class="form-select form-select-sm" name="exp_status" id="exp_status">
                <option value="">All</option>
                <option value="1" <?php if ($exp_val == 1) { print "selected='selected'";} ?>>Active</option>
                <option value="2" <?php if ($exp_val == 2) { print "selected='selected'";} ?>>Expires in 30 days</option>
                <option value="3" <?php if ($exp_val == 3) { print "selected='selected'";} ?>>Expires in 10 days</option>
                <option value="4" <?php if ($exp_val == 4) { print "selected='selected'";} ?>>Expires Today</option>
                <option value="5" <?php if ($exp_val == 5) { print "selected='selected'";} ?>>Expired</option>
            </select>                    
            <div>
            </div>
        </div>
        <div class="me-1">
            <label class="form-label mb-0">Project&nbsp;:&nbsp;</label>
            <select name="project_val" class="form-select form-select-sm" aria-label="Projects" id="project_val">
                <option value="0" <?= $project_val == "0" ? "selected" : ""; ?>>All Projects</option>
                <?php if (isset($projects) and !empty($projects)) { 
                    foreach ($projects as $project) { ?>
                    <option <?= $project_val == $project['id'] ? "selected" : ""; ?> value="<?= $project['id']; ?>">
                        <?= $project['name'] . " (" . $project['code'] . ")"; ?>
                    </option>
                <?php } 
                } ?> 
            </select>
        </div>
        <div class="me-1">
            <label class="form-label mb-0">&nbsp;</label>
            <div>
                <button class="btn btn-sm btn-success" type="button" onclick="bankGauranteeBody(<?= $rows ?>, <?= $pageno ?>, '<?= $sortby ?>', '<?= $sort_order ?>')"><i class="bi bi-search"></i></button>
                <button class="btn btn-sm btn-warning" onclick="refreshBG()"><i class="bi bi-arrow-clockwise"></i></button>
            </div>
        </div>
        <div class="me-1">
            <label class="form-label mb-0">&nbsp;</label>
            <div>
                <strong>(&nbsp;<?= $tRecords ?>&nbsp;Records&nbsp;)</strong>
            </div>
        </div>
    </div>
    <div class="float-end d-flex align-items-center">
        <div class="me-1">
            <label class="form-label mb-0">&nbsp;</label>
            <div>
                <button type="button" class="btn btn-success btn-sm" onclick="addBG()"><i class="bi bi-plus-square"></i>&nbsp;Add BG</button>
            </div>
        </div>
        <div class="me-1">
            <label class="form-label mb-0">&nbsp;</label>
            <select class="form-select form-select-sm" name="rows" id="rows" onchange="bankGauranteeBody(this.value, <?= $pageno ?>, '<?= $sortby ?>', '<?= $sort_order ?>')">
                <option value="10" <? if($rows == 10 ){ print 'selected="selected"'; } ?>>10Records</option>
                <option value="20"  <? if($rows == 20 ){ print 'selected="selected"'; } ?>>20Records</option>
                <option value="50"  <? if($rows == 50 ){ print 'selected="selected"'; } ?>>50Records</option>
                <option value="100" <? if($rows == 100 ){ print 'selected="selected"'; } ?>>100Records</option>
                <option value="1000" <? if($rows == 1000 ){ print 'selected="selected"'; } ?>>1000Records</option>
            </select>
        </div>
        <div class="me-0">
            <label class="form-label mb-0">&nbsp;</label>
            <nav aria-label="Page navigation example">
                <ul class="pagination pagination-sm mb-0 inv-tracking-pagination">
                    <? 
                    if ($pageno == "1") { ?>
                        <li class="page-item disabled">
                            <a class="page-link" href="javascript:void(0);"><i class="bi bi-chevron-double-left"></i></a>
                        </li>
                        <li class="page-item disabled">
                            <a class="page-link" href="javascript:void(0);"><i class="bi bi-chevron-left"></i></a>
                        </li>
                    <?
                    }
                    else {
                        ?>
                        <li class="page-item">
                            <a class="page-link" href="javascript:void(0);" onclick="bankGauranteeBody(<?= $rows ?>, 1, '<?= $sortby ?>', '<?= $sort_order ?>')"><i class="bi bi-chevron-double-left"></i></a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="javascript:void(0);" onclick="bankGauranteeBody(<?= $rows ?>, <?= $pageno-1 ?>, '<?= $sortby ?>', '<?= $sort_order ?>')"><i class="bi bi-chevron-left"></i></a>
                        </li>
                    <?
                    }
                    ?>
                    <li class="page-item active" aria-current="page">
                        <span class="page-link p-0 text-white inv-tracking-select">
                            <select class="form-select form-select-sm" name="rows" onchange="bankGauranteeBody(<?= $rows ?>, this.value, '<?= $sortby ?>', '<?= $sort_order ?>')">
                                <option value="<?= $pageno  ?>" ><?= $pageno  ?>/<?= $total_pages ?></option>                              
                            </select>
                        </span>
                    </li>
                    <?
                    if ($pageno == $total_pages) {
                        ?>
                        <li class="page-item disabled">
                            <a class="page-link" href="javascript:void(0);"><i class="bi bi-chevron-right"></i></a>
                        </li>
                        <li class="page-item disabled">
                            <a class="page-link" href="javascript:void(0);"><i class="bi bi-chevron-double-right"></i></a>
                        </li>
                    <?
                    }
                    else { ?>
                        <li class="page-item">
                            <a class="page-link" href="javascript:void(0);" onclick="bankGauranteeBody(<?= $rows ?>, <?= $pageno+1 ?>, '<?= $sortby ?>', '<?= $sort_order ?>')" ><i class="bi bi-chevron-right"></i></a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="javascript:void(0);" onclick="bankGauranteeBody(<?= $rows ?>, <?= $total_pages ?>, '<?= $sortby ?>', '<?= $sort_order ?>')"><i class="bi bi-chevron-double-right"></i></a>
                        </li>
                    <?
                    }
                    ?>
                </ul>
            </nav>
        </div>
    </div>
</div>
<div class="table table-responsive mt-2 freeze-table">
    <table class="table table-bordered table-hover table-striped table-condensed">
        <thead>
            <tr class="align-middle">
                <th nowrap width="1%" class="text-center">S.No.</th>
                <th nowrap><? if($sortby == 'p.name') print $arrow; ?><a href="javascript:void(0)" onclick="bankGauranteeBody('<? echo $rows; ?>','<? print $pageno; ?>','p.name','<? echo $sort_order_alt; ?>')">Project</a></th>
                <th nowrap><? if($sortby == 'bt.name') print $arrow; ?><a href="javascript:void(0)" onclick="bankGauranteeBody('<? echo $rows; ?>','<? print $pageno; ?>','bt.name','<? echo $sort_order_alt; ?>')">BG Type</a></th>
                <th nowrap><? if($sortby == 'project_bg.bg_number') print $arrow; ?><a href="javascript:void(0)" onclick="bankGauranteeBody('<? echo $rows; ?>','<? print $pageno; ?>','project_bg.bg_number','<? echo $sort_order_alt; ?>')">BG Number</a></th>
                <th nowrap><? if($sortby == 'project_bg.bg_bank') print $arrow; ?><a href="javascript:void(0)" onclick="bankGauranteeBody('<? echo $rows; ?>','<? print $pageno; ?>','project_bg.bg_bank','<? echo $sort_order_alt; ?>')">Bank Name</a></th>
                <th nowrap><? if($sortby == 'project_bg.name') print $arrow; ?><a href="javascript:void(0)" onclick="bankGauranteeBody('<? echo $rows; ?>','<? print $pageno; ?>','project_bg.name','<? echo $sort_order_alt; ?>')">Name of the Party</a></th>
                <th nowrap class="text-end"><? if($sortby == 'project_bg.bg_amount') print $arrow;?><a href="javascript:void(0)" onclick="bankGauranteeBody('<? echo $rows; ?>','<? print $pageno; ?>','project_bg.bg_amount','<? echo $sort_order_alt; ?>')">BG Amount</a></th>
                <th nowrap><? if($sortby == 'project_bg.issue_date') print $arrow; ?><a href="javascript:void(0)" onclick="bankGauranteeBody('<? echo $rows; ?>','<? print $pageno; ?>','project_bg.issue_date','<? echo $sort_order_alt; ?>')">BG Issue Date</a></th>
                <th nowrap><? if($sortby == 'project_bg.valid_date') print $arrow; ?><a href="javascript:void(0)" onclick="bankGauranteeBody('<? echo $rows; ?>','<? print $pageno; ?>','project_bg.valid_date','<? echo $sort_order_alt; ?>')">Expiry Date</a></th>
                <th nowrap>Expiry Status</th>
                <th nowrap class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            <? 
            if (isset($bank_guarentees) and !empty($bank_guarentees)) {
                foreach ($bank_guarentees as $key => $bg) { 
                    ?>
                    <tr>
                        <td nowrap class="text-center"><?= $i++ ?></td>
                        <td nowrap><?= $bg['project_name']." ( ".$bg['project_code']." ) " ?></td>
                        <td nowrap><?= $bg['bg_type'] ?></td>
                        <td nowrap><?= $bg['bg_number'] ?></td>
                        <td nowrap><?= $bg['bg_bank'] ?></td>
                        <td nowrap><?= $bg['name'] ?></td>
                        <td nowrap class="text-end"><?= displayMoney($bg['bg_amount'],2) ?></td>
                        <td nowrap><?= displayDate($bg['issue_date']) ?></td>
                        <td nowrap><?= displayDate($bg['valid_date']) ?></td>
                        <td nowrap>
                            <?
                             if(isset($bg['valid_date'])) { 
                                    $consumer_timestamp = strtotime($bg['valid_date']);
                                }
                                else { 
                                    $consumer_timestamp = 0;
                                }
                                $exp = 0;
                                $current_timestamp = strtotime(date('Y-m-d'));
                                $days = floor(($consumer_timestamp - $current_timestamp)/(24*60*60));
                                // print $days1;

                                if ($days >= 30) {
                                    print "<span class='badge rounded-pill bg-success'>Expires in ".$days." days</span>";
                                } elseif ($days < 30 && $days >= 10) {
                                    print "<span class = 'badge rounded-pill bg-warning text-dark'>Expires in ".$days." days.</span>";
                                } elseif ($days < 10 && $days > 0) {
                                    print "<span class='badge rounded-pill bg-danger'>Expires in ".$days." days.</span>";
                                } elseif ($days == 0) {
                                    print "<span class='badge rounded-pill bg-danger'>Expires Today.</span>";
                                } elseif ($days < 0) {
                                    $exp = 1;
                                    print "<span class='badge rounded-pill bg-secondary'>Expired</span>";
                                }
                                ?>
                                
                        </td>
                        <td nowrap class="text-center">
                            <div class="dropdown">
                                <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="actionMenu" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-list"></i></button>
                                <ul class="dropdown-menu" aria-labelledby="actionMenu">
                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="viewBG(<?= $bg['id'] ?>)"><i class="bi bi-info-square"></i>&nbsp;View</a></li>
                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="editBG(<?= $bg['id'] ?>)"><i class="bi bi-pencil-square"></i>&nbsp;Edit</a></li>
                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="deleteBG(<?= $bg['id'] ?>)"><i class="bi bi-x-square"></i>&nbsp;Delete</a></li>
                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="viewBgHistory(<?= $bg['id'] ?>)"><i class="bi bi-clock-history"></i>&nbsp;History</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    <?
                }
            }
            else { ?>

                <tr>
                    <td colspan="11">
                        <div class="alert alert-warning">No Records found</div>
                    </td>
                </tr>
                <?
            }
            ?>            
        </tbody>
    </table>
</div>
<script type="text/javascript">
    $(function() {
        $('#complete_date').datepicker({format:'dd-mm-YYYY', autoHide:true});
        $('#extens_date').datepicker({format:'dd-mm-YYYY', autoHide:true});
        $('.freeze-table').freezeTable({freezeColumn: true, columnNum: 2});
   });
</script>