<?php function echo_stat_cards($info, $date, $car, $laps, $col_card): void { ?>
    <div class="row">
        <?php $j = 0; ?>
        <?php for ($i = 0; $i < count($date); $i++) { ?>
            <div class="<?php echo $col_card ?> d-flex align-items-stretch py-3">
                <div class="w-100 card border border-danger border-3 p-2 d-flex flex-column justify-content-between">
                    <div>
                        <h4 class="d-flex justify-content-center text-align-center"><strong><?php echo htmlentities($info[$j]) ?></strong></h4>
                        <hr>
                        <div class="card-body d-flex align-items-end">
                            <div class="w-100">
                                <ul>
                                    <li>
                                        <h6 class="card-title text-danger"><strong>Date: </strong><?php echo htmlentities($date[$i]); ?> </h6>
                                    </li>
                                    <li>
                                        <?php $j += 1; ?>
                                        <h6 class="card-title text-danger"><strong>Winner: </strong> <?php echo htmlentities($info[$j]); $j += 1; ?> </h6>
                                    </li>
                                    <li>
                                        <h6 class="card-title text-danger"><strong>Car: </strong><?php echo htmlentities($car[$i]); ?> </h6>
                                    </li>
                                    <li>
                                        <h6 class="card-title text-danger"><strong>Laps: </strong><?php echo htmlentities($laps[$i]); ?> </h6>
                                    </li>
                                </ul>
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





