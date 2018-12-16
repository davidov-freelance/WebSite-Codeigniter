
<?php foreach($result AS $key => $row):?>
    <?php $sum_profit = $row["profit_confirm"] + $row["profit_pending"] + $row["profit_reflected"];?>
    <tr>
        <?php
        if(isset($two_column)){
            $subs = explode(" - ", $key);
            $key = $subs[0];
            $row['two'] = (!empty($subs[1])) ? $subs[1] : '';
        }

        if(isset($three_column)){
            $subs = explode(" - ", $key);
            $key = $subs[0];
            $row['three'] = (!empty($subs[2])) ? $subs[2] : '';
        }

        if(isset($four_column)){
            $subs = explode(" - ", $key);
            $key = $subs[0];
            $row['four'] = (!empty($subs[3])) ? $subs[3] : '';
        }

        ?>
        <td class="sub1_column"><?php echo (strlen($key) > 25 ? mb_substr($key, 0, 25) . "..." : $key);?></td>

        <?php if(isset($two_column)):?>
            <td class="text-center sub2_column"><?=$row["two"];?></td>
        <?php endif;?>

        <?php if(isset($three_column)):?>
            <td class="text-center"><?=$row["three"];?></td>
        <?php endif;?>

        <?php if(isset($four_column)):?>
            <td class="text-center"><?=$row["four"];?></td>
        <?php endif;?>


        <?php if($this->user_model->isAdmin()):?>
            <?php switch($type){
                case "days":
                    $url_transits = base_url() . "admin/visitors/index/" . $this->stat_model->getUserId() . "/" . $key . "/" . $key;
                    break;
                case "flows":
                    $url_transits = base_url() . "admin/visitors/index/" . $this->stat_model->getUserId() . "/0/0/" . $row["flow_id"];
                    break;
                case "offers":
                    $url_transits = base_url() . "admin/visitors/index/" . $this->stat_model->getUserId() . "/0/0/0/" . $row["offer_id"];
                    break;
            }
            ?>

            <?php /* <td class="text-center"><a href="<?=$url_transits;?>"><?=$row["click_all"];?></a></td> */ ?>
            <td class="text-center"><?=$row["click_all"];?></td>
        <?php else:?>
            <td class="text-center"><?=$row["click_all"];?></td>
        <?php endif;?>
        <td class="text-center"><?=getConversion($row["requests_all"], $row["click_all"], false);?></td>
        <td class="text-center"><?=getEPC($row["profit_confirm"], $row["click_all"], false);?></td>
        <td class="text-center"><?=$row["requests_all"];?></td>
        <td class="text-center"><?=$row["requests_confirm"];?></td>
        <td class="text-center"><?=$row["requests_pending"];?></td>
        <td class="text-center"><?=$row["requests_reflected"];?></td>
        <td class="text-center"><?=getNormalMoney($sum_profit);?></td>
        <td class="text-center"><?=getNormalMoney($row["profit_confirm"]);?></td>
        <td class="text-center"><?=getNormalMoney($row["profit_pending"]);?></td>
        <td class="text-center"><?=getNormalMoney($row["profit_reflected"]);?></td>
    </tr>
<?php endforeach;?>
