<?php
/**
 * BG reminder mail body
 */

// Check and 
if($bg_data) {
    ?>
    <table cellspacing="0" cellpadding="5" border="1">
        <thead>
            <tr bgcolor="#E2E2E2">
                <th>S.No</th>
                <th>BG Number</th>
                <th>Bank</th>
                <th>Name of the party</th>
                <th>Amount</th>
                <th>Expires On</th>
            </tr>
        </thead>
        <tbody>
            <?
            $sno = 1;
            foreach($bg_data as $bg) {
                ?>
                <tr>
                    <td><?= $sno++ ?></td>
                    <td><?= $bg['bg_number'] ?></td>
                    <td><?= $bg['bg_bank'] ?></td>
                    <td><?= $bg['name'] ?></td>
                    <td><?= displayNumber($bg['bg_amount']) ?></td>
                    <td><?= displayDate($bg['valid_date']) ?></td>
                </tr>
                <?
            }
            ?>
        </tbody>
    </table>
    <?
}
?>