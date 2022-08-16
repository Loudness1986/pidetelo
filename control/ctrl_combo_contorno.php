<?php
require_once '../clases/cls_load.php';
$obj = new load();

$select = $obj->load_con("SELECT * FROM contorno");
?>
<select class="form-control"   name="conto[]" style="margin-top: 5px">
    <option value='-' >      Seleccione</option>
<?php
while ($row = $obj->load_arry($select)) {
    ?>
    <option value='<?php echo $row['cod_con']?>' ><?php echo $row['nom_con']?></option>

    <?php
}
?>
</select>