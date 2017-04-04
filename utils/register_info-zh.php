<div class="form-group container vertical-center-parent">
    <label class="control-label col-xs-4 input-left vertical-center">入学年份:</label>
    <div class="col-xs-8 input-right">
        <input type="text" class="form-control" <?php echo "id='promo-$id'" ?> placeholder="入学年份">
    </div>
</div>
<div class="form-group container vertical-center-parent">
    <label class="control-label col-xs-4 input-left vertical-center">院系:</label>
    <div class="col-xs-8 input-right">
        <div class="custom-selectbox">
            <select class="custom-select" <?php echo "id='dept-$id'" ?>>
                <?php
                echo "<option></option>";
                for ($i = 0; $i < count($_SESSION["DEPARTEMENT_ARRAY"]); $i++) {
                    echo "<option>" . $_SESSION['DEPARTEMENT_ARRAY'][$i] . "</option>";
                }
                ?>
            </select>
        </div>
    </div>
    <div <?php echo "id='error-$id'" ?>></div>
</div>

