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
    <h4>Update lan.list file with a new dns record</h4>
</div>
<div class="row">
    <div class="col-md-12">
<?php
	$save_file = $_POST['save_file'];
	$r_dns = $_POST['r_dns'];
	$savecontent = $_POST['savecontent'];
	$loadcontent = "/etc/pihole/lan.list";
	$add="";
	$lb="";
        if($save_file) {
            $savecontent = stripslashes($savecontent);
			
			file_put_contents($loadcontent,$savecontent);
        }
		
		if($r_dns){
			shell_exec("sudo pihole restartdns");
		}
		
    $loadcontent_t = @htmlspecialchars(file_get_contents($loadcontent));
	if(!strpos($loadcontent_t,"Local DNS Resolution List")){
		$add="# Local DNS Resolution List #\n#ipaddress fqdn hostname\n\n";
	}
	if(substr($loadcontent_t,-1) !== "\n") {
		$lb="\n";
	}
	$loadcontent_t = $add.$loadcontent_t.$lb;
	
	if($lb!=="" || $add!==""){
		file_put_contents($loadcontent,$loadcontent_t);
	}

?>
<form method=post action="<?=$_SERVER['PHP_SELF']?>">
	<textarea style="margin:10px;width:98%" name="savecontent" cols="70" rows="25"><?=$loadcontent_t?></textarea>
	<br>
	<input type="submit" name="save_file" value="Save">
	<input type="submit" name="r_dns" value="Restart DNS">
</form>
    </div>
</div>

<?php
    require "scripts/pi-hole/php/footer.php";
?>
