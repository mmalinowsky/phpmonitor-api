<VirtualHost *:80>
    ServerName      {{app.domain}}
    DocumentRoot    {{deploy_path}}/current/src/public
    ErrorLog        {{deploy_path}}/apache-error.log
    CustomLog       {{deploy_path}}/apache-access.log combined

    <Directory {{deploy_path}}/current/src/public>
        AllowOverride All
        Options +FollowSymLinks
    </Directory>
</VirtualHost>