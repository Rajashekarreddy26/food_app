<?php
/**
 * Invoice tracking
 * Bank guarantees history
 */
?>
<div class="modal-dialog modal-xl">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Bank Guarantee History</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <? 
            if (isset($bg_history_data) and !empty($bg_history_data)) {
                ?>
                <div class="table table-responsive mt-2">
                    <table class="table table-bordered table-hover table-striped table-condensed">
                        <thead>
                            <tr class="align-middle">
                                <th width="1%" class="text-center">S.No.</th>
                                <th nowrap="">BG Number</th>
                                <th nowrap="">Bank Name</th>
                                <th nowrap="">Name of the Party</th>
                                <th nowrap="" class="text-end">BG Amount</th>
                                <th nowrap="">BG Issue Date</th>
                                <th nowrap="">Expiry Date</th>
                                <th nowrap="">Expiry Status</th>
                                <th nowrap="" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?
                            $i = 1;
                            foreach ($bg_history_data as $key => $bg) { 
                                ?>
                                <tr>
                                    <td class="text-center"><?= $i++ ?></td>
                                    <td><?= $bg['bg_number'] ?></td>
                                    <td><?= $bg['bg_bank'] ?></td>
                                    <td><?= $bg['name'] ?></td>
                                    <td class="text-end"><?= displayMoney($bg['bg_amount'],2) ?></td>
                                    <td><?= displayDate($bg['issue_date']) ?></td>
                                    <td><?= displayDate($bg['valid_date']) ?></td>
                                    <td>
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
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-danger" onclick="deleteBgHistory(<?= $bg['id'] ?>)"><i class="bi bi-trash"></i>&nbsp;Delete</button>
                                    </td>
                                </tr>
                                <?
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <?
            }
            else {
                ?><div class="alert alert-warning">No Records found</div><?
            }
            ?>            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i class="bi bi-x-square"></i>&nbsp;Close</button>
        </div>
    </div>
</div>