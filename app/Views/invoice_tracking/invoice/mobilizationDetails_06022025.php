<?php
$mobil_adv_amt = (isset($mobil_adv['mobilization_adv']) AND !empty($mobil_adv['mobilization_adv'])) ? $mobil_adv['mobilization_adv'] : 0;
$mobil_adv_avail_amt = (isset($mobil_adv['mobilization_adv_available']) AND !empty($mobil_adv['mobilization_adv_available'])) ? $mobil_adv['mobilization_adv_available'] : 0;
$mobil_adv_per = (isset($mobil_adv['mobilization_per']) AND !empty($mobil_adv['mobilization_per'])) ? $mobil_adv['mobilization_per'] : 0;
?>
<div class="row mb-3">
    <label class="col-sm-3 col-form-label text-end">Mobilization Balance:</label>
    <div class="col-sm-7">
        <input type="text" id="mobilizationAdv" class="form-control" value="<?= $mobil_adv_amt ?>" readonly>
    </div>
</div>

<div class="row mb-3">
    <label class="col-sm-3 col-form-label text-end">Remaining Mobilization Balance:</label>
    <div class="col-sm-7">
        <input type="text" id="mobilizationAdvAvailable" class="form-control" value="<?= $mobil_adv_avail_amt ?>" readonly>
    </div>
</div>

<div class="row mb-3">
    <label class="col-sm-3 col-form-label text-end">Mobilization Percentage:</label>
    <div class="col-sm-7">
        <input type="text" id="mobilizationPer" class="form-control" value="<?= $mobil_adv_per ?>"readonly>
    </div>
</div>
