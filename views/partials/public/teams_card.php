<?php function echo_teams_cards($name_list, $lastname_list, $team_list, $img_list, $col_card): void { ?>
    <div class="row">
        <?php $j = 0; ?>
        <?php for ($i = 0; $i < 10; $i++) { ?>
            <div class="<?php echo $col_card ?> d-flex align-items-stretch py-3">
                <div class="w-100 card border border-danger border-3 p-2 d-flex flex-column justify-content-between">
                    <div>
                        <h4 class="d-flex justify-content-center text-align-center"><strong><?php echo htmlentities($team_list[$i]) ?></strong></h4>
                        <hr>
                        <div class="card-img">
                            <img src="<?php echo $img_list[$j+1] ?>" class="card-img-top" alt="...">
                        </div>
                        <div class="card-body d-flex align-items-end">
                            <div class="w-100">
                                <p><strong>Pilots</strong></p>
                                <ul>
                                    <li>
                                        <h6 class="card-title text-danger"><?php echo htmlentities($name_list[$j]."\t".$lastname_list[$j]); ?> </h6>
                                    </li>
                                    <?php ++$j; ?>
                                    <li>
                                        <h6 class="card-title text-danger"><?php echo htmlentities($name_list[$j]."\t".$lastname_list[$j]); ?> </h6>
                                    </li>
                                </ul>
                                <hr>
                                <p><strong>Logo: </strong><img style="position: relative; left:140px; height: 40px; width: 40px" src="<?php echo $img_list[$j-1] ?>" alt="..."></p>
                                <?php ++$j; ?>
                                <hr>
                            </div>
                        </div>
                    </div>
                    <div id="info_driver<?php echo $i ?>">

                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
<?php } ?>




