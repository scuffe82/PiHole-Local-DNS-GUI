# PiHole-Local-DNS-GUI
I was tired of logging into the console to edit the lan.list file when i added new records so i added a basic editor to the GUI. This is a frist stab at it and while its fully functional there is no error checking or anything fancy. If there is enough interest i'll make it more record based and add error checking. The other solution i keep reading is to use PiHole as my DHCP server and assign out addresses that way but for my environment that doesn't work out. Also once the new UI comes out i will have to update this to be compatible with it.

Prereq: Make sure you have PiHole setup to serve local DNS:

https://discourse.pi-hole.net/t/howto-using-pi-hole-as-lan-dns-server/533


Install Steps:

1)Copy the local_dns.php file to /var/www/html/admin/

2)Edit the file /var/www/html/admin/scripts/pi-hole/php/header.php (details also in header_edit.txt for reference)

Find the section that looks like this:
------------------------------------------------------------------------------
```
<!-- Help -->
<li<?php if($scriptname === "help.php"){ ?> class="active"<?php } ?>>
     <a href="help.php">
          <i class="fa fa-question-circle"></i> <span>Help</span>
     </a>
</li>
```
------------------------------------------------------------------------------

Add the following section below it:
------------------------------------------------------------------------------
```
<!--add local dns-->
<li<?php if($scriptname === "local_dns.php"){ ?> class="active"<?php } ?>>
     <a href="local_dns.php">
          <i class="fa"></i> <span>Add Local DNS Record</span>
    </a>
</li>
```
------------------------------------------------------------------------------

After the edit it should look something like this:
---
```
      <?php if($auth){ ?>
      <!-- Help -->
      <li<?php if($scriptname === "help.php"){ ?> class="active"<?php } ?>>
           <a href="help.php">
                <i class="fa fa-question-circle"></i> <span>Help</span>
           </a>
      </li>
      <!--add local dns-->
      <li<?php if($scriptname === "local_dns.php"){ ?> class="active"<?php } ?>>
          <a href="local_dns.php">
               <i class="fa"></i> <span>Add Local DNS Record</span>
          </a>
      </li>
      <?php } ?>
   </ul>
</section>
```

Refresh the GUI and you should now have a new nav bar option to add local dns. The text field will load your lan.list file from 
/etc/pihole/ and allow you to edit it, save and restart the dnsmasq service. If the header.php file gets updated you will have to add the link back in or just load the page with the url 
https://YOURPIHOLE.local/admin/local_dns.php

The format of the file is:
IP FQDN Shortname

eg:
10.0.0.1 myrouter.mydomain.local myrouter

If you enter things incorrectly the service might not restart.

