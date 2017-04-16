# NJU-alumni-website
    
    For photo upload and visitor counter to work we need to make the owner of those folders same as httpd process owner OR make them globally writable.
    
    1.Check apache process owner: $ps aux | grep httpd. The first column will be the owner typically it will be nobody
    
    2.Change the owner of photoDatabase and counterFolder to be become nobody or whatever the owner you found in step 1.

        $ sudo chown nobody /var/XAMPP/root/NJU-alumni-website/photoDatabase/

        $ sudo chown nobody /var/XAMPP/root/NJU-alumni-website/utils/counterFolder/

    3.Chmod photoDatabase and counterFolder now to be writable by the owner, if needed. 

        $ sudo chmod -R 0777 /var/XAMPP/root/NJU-alumni-website/photoDatabase/

        $ sudo chmod -R 0777 /var/XAMPP/root/NJU-alumni-website/utils/counterFolder/
    

    Although our site requires an email as user name, you can still sign in with user name : "olivier" and password : "lapin"
    
    and user name : "dominique" and password : "renard". We don't have administrative account.