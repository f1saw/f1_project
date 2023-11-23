# f1_project
SAW project about F1

# TO-DO:
<ul>
<li>Check code HTTP code errors</li>
<li>Hash cookie in DB</li>
<li>Generic error page</li>
<li>Proteggere tutti file server rilevanti (tipo DB.php, ...)</li>
</ul>

ALTER TABLE Users DROP FOREIGN KEY fk_cookie_id;
ALTER TABLE Users ADD FOREIGN KEY (cookie_id) REFERENCES  Cookies(id) ON UPDATE CASCADE ON DELETE SET NULL;