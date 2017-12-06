<<<<<<< HEAD
<?php
/**
 * Created by PhpStorm.
 * User: fmbv
 * Date: 06/10/2017
 * Time: 19:16
 */
?>
<input type="hidden" id="haccion" name="haccion" value="<?php if (isset($_POST['haccion'])) echo $_POST['haccion']; ?>">
<input type="hidden" id="hmod" name="hmod" value="<?php if (isset($_POST['hmod'])) {echo $_POST['hmod'];}else{echo "";} ?>">
<!-- apertura etiqueta en tpl.php-->
=======
<?php
/**
 * Created by PhpStorm.
 * User: fmbv
 * Date: 06/10/2017
 * Time: 19:16
 */
?>
<input type="hiddenn" id="haccion" name="haccion" value="<?php if (isset($_POST['haccion'])) echo $_POST['haccion']; ?>">
<input type="hiddenn" id="hmod" name="hmod" value="<?php if (isset($_POST['hmod'])) {echo $_POST['hmod'];}else{echo "";} ?>">
<!-- apertura etiqueta en tpl.php->
>>>>>>> retomar
</form>