<div class="form-group container vertical-center-parent">
    <label class="control-label col-xs-4 input-left vertical-center">Votre promotion&nbsp;:</label>
    <div class="col-xs-8 input-right">
        <input type="text" class="form-control" <?php echo "id='promo-$id'"?> placeholder="promotion">
    </div>
</div>
<div class="form-group container vertical-center-parent">
    <label class="control-label col-xs-4 input-left vertical-center">Votre département&nbsp;:</label>
    <div class="col-xs-8 input-right">
        <select class="form-control" <?php echo "id='dept-$id'"?>>
            <option></option>
            <option>Département de Physique</option>
            <option>Département de Mathématiques</option>
            <option>Département de Chimie</option>
            <option>Département de Biologie</option>
        </select>
    </div>
    <div <?php echo "id='error-$id'"?>></div>
</div>

