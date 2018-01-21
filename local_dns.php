<?php
    require "scripts/pi-hole/php/header.php";

    if(strlen($pwhash) > 0)
    {
        $authenticationsystem = true;
    }
    else
    {
        $authenticationsystem = false;
    }
?>

<div class="row">
    <div class="col-md-12">
    <h1>Add Local DNS Record</h1>
    <h4>Update lan.list with a new dns record</h4>
</div>
<div class="row">
    <div class="col-md-12">
<?php
$save_file = $_POST['save_file'];
$savecontent = $_POST['savecontent'];
$loadcontent = "/etc/pihole/lan.list";
        if($save_file) {
                $savecontent = stripslashes($savecontent);
                $fp = @fopen($loadcontent, "w");
                if ($fp) {
                        fwrite($fp, $savecontent);
                        fclose($fp);
                                                           }
                                }
        $fp = @fopen($loadcontent, "r");
                $loadcontent = fread($fp, filesize($loadcontent));
                $loadcontent = htmlspecialchars($loadcontent);
                fclose($fp);

?>
<form method=post action="<?=$_SERVER['PHP_SELF']?>">
<textarea name="savecontent" cols="70" rows="25"><?=$loadcontent?></textarea>
<br>
<input type="submit" name="save_file" value="Save">
<form action="<?php shell_exec("sudo pihole restartdns");?>" method="get">
  <input type="submit" value="Restart DNS">
</form>
</form>
    </div>
</div>

<?php
    require "scripts/pi-hole/php/footer.php";
?>
