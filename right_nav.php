<div id="tabContainer">
    <div id="tabscontent">
		<div class="zoom_right">
			<fieldset>
				<legend>Zoom</legend>
				<input type="button" class="little_button" value="+" onclick="change_scale(.05)" />
				<input type="button" class="little_button" value="-" onclick="change_scale(-.05)" />
			</fieldset>
		</div>
		<div class="detail_right">
			<fieldset>
				<legend>Detail</legend>
				<input type="text" id="detail" style="border:0; color:#f6931f;" />
				<div id="slider"></div>
			</fieldset>
		</div>
        <div class="tabpage">
                    <h3>Default:</h3>
                    <ul>
                    <li><input type="radio" name="focus" value="outcome1" onClick="updategraph('default',0,<?php if(array_key_exists('graphDetail', $_GET)) {echo $_GET['graphDetail'];}else{echo 0;}?>)"
                    <?php
                        if($graphType == 'default'){
                            echo "checked";
                        }
                    ?>
                    > Scenario Overview</li>
                </ul>
                <h3>Outcomes:</h3>
                <ul>
                <?php
                    $sql = "select pa.parentArgumentID, pa.level, pa.status, CASE
                    WHEN b.isNegated=1 THEN concat('NOT(',p.name,'(',c.name,'))')
                    ELSE concat(p.name,'(',c.name,')') END predicate
                    from parent_argument pa
                    inner join arguments a on a.argumentID = pa.argumentID and a.timestep = pa.timestep and pa.sessionID = a.sessionID
                    inner join beliefs b on b.beliefID = a.beliefID
                    inner join predicate_has_constant pc on pc.predicateConstantID = b.conclusionID
                    inner join predicates p on p.predicateID = pc.predicateID
                    inner join constants c on pc.constantID = c.constantID
                    where pa.sessionID = '".$sessionID."' and pa.timestep=".$timestep." and a.isSupported = 1;";

                    $result=mysqli_query($link,$sql);

                    if ($result) {
                        while ($row = mysqli_fetch_array($result)) {
                ?>
                    <li><input type="radio" name="focus" value="outcome" onClick="updategraph('argument',<?php echo $row[0]; ?>,
                        <?php if(array_key_exists('graphDetail', $_GET)) {echo $_GET['graphDetail'];}else{echo 0;}?>)"
                        <?php if((array_key_exists('argumentID', $_GET))&&($row[0]==$_GET['argumentID'])) {?> checked <?php }?>>
                        <?php echo $row[3]; ?>: <?php echo $row[1]; ?></input>
                    </li>
                <?php
                        }
                    }
                    mysqli_free_result($result);
                ?>
                </ul>
                <?php if ($graphDetail > 1){ ?>
                    <h3> Observed Knowledge:</h3>
                <ul>
                <?php
                    $sql="call getFacts('".$sessionID."', ".$timestep.",1,0);";
                    if (mysqli_multi_query($link,$sql)) {
                        do {
                            /* store first result set */
                            if ($result = mysqli_store_result($link)) {
                                while ($row = mysqli_fetch_array($result)) {
                ?>
                    <li><input type="radio" name="focus" value="<?php echo $row[1]; ?>" onClick="updategraph('belief',<?php echo $row[0]; ?>,3)"
                        <?php if((array_key_exists('beliefID', $_GET))&&($row[0]==$_GET['beliefID'])) {?> checked <?php }?>>
                        <?php echo $row[1]; ?></input></li>
                <?php
                                }
                                $result->free();
                            }
                        } while (mysqli_next_result($link));
                    }else{
                        echo "error running agents query";
                    }
                    echo "</ul>";
                }//close if statement
                if ($graphDetail > 2){
                ?>
                    <h3>Inferred Knowledge:</h3>
                <?php
                    $sql="call getRules('".$sessionID."', ".$timestep.",1,0);";
                    if (mysqli_multi_query($link,$sql)) {
                        do {
                            /* store first result set */
                            if ($result = mysqli_store_result($link)) {
                                while ($row = mysqli_fetch_array($result)) {
                ?>
                    <li><input type="radio" name="focus" value="<?php echo $row[1]; ?>" onClick="updategraph('rule',<?php echo $row[0]; ?>,3)"
                        <?php if((array_key_exists('ruleID', $_GET))&&($row[0]==$_GET['ruleID'])) {?> checked <?php }?>>
                        <?php echo $row[1]; ?></input></li>
                <?php
                                }
                                $result->free();
                            }
                        } while (mysqli_next_result($link));
                    }else{
                        echo "error running agents query";

                    }
                }//close if statement
                ?>
                </ul>
        </div>
    </div>
</div>