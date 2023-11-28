# f1_project
SAW project about F1

# TO-DO:
<ul>
<li>Check code HTTP code errors</li>
<li>Generic error page</li>
<li>Proteggere tutti file server rilevanti (tipo DB.php, ...)</li>
<li>Recupero password</li>

<hr>

MAURI:
<li>percorso file con /</li>
<li>update e delete user</li>

<hr>

MATTE:
<li>fix grafico tabella dashboard</li>
<li>stile home scuro/rosso</li>
<li>init grafico circuiti (sotto forma di cards)</li>

</ul>
PROBLEMI
<li>auth.php: la variabile $_SESSION['id'] contiene l'identificativo del cookie. Come ottengo quello dell'utente?</li>
<li>user_detail: tralasciando la grafica fatta a caso, perchè $element['first_name'] etc. non stampa niente?</li>
<li>
    user_delete: perchè gli header danno quasi sempre 404 not found? (tipo quando elimino utente non rimanda alla pagina - stesso problema altri file)
    nota: il controllo $_SESSION["id"] != $_GET["id"] non funziona per quanto detto prima (la var di sessione non contiene id utente)
</li>
