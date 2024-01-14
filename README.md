# f1_project
SAW project about F1

# CLONE (w/ submodules):
- ```git clone --recursive-submodule {.git}```
<br>or<br>
```git submodule update --init --recursive```
- Update submodule ```git submodule update --remote```

<hr>

## MAURI:
- [ ] quando viene cambiata la mail errore se già presente, altrimenti mandare email per verifica
- [ ] **+** in edit_user => htmlentities, real_escape_string + conn->close@32


<hr>

## MATTE:
- [ ] ragionare su DB al posto del LocalStorage per memorizzare il carrello degli utenti
- [ ] NOT Working: dynamic tooltip on "cart" in order to quickly remove items from cart
- (teams evolution: https://i.redd.it/rp22ueq8ctea1.png)
<hr>


## NOTES:
- search.php => search ! match /\s*/
- Cosa significa "Logged but in user mode, Logout" => fare redirect su dashboard?
- Cos'è assets/image/User_detail*
- Rivedere utilizzo utility/msg_error.php (reindirizzare secondo edit.php?id=$id)

## ALL:
- [ ] Difference between !...! and /.../ in regex (fare test) 
- [ ] Footer
- [ ] fare redirect su 404.php per ogni file tipo controllers/controllers/auth/auth.php
- [ ] mettere err_msg e succ_msg in dashboard.php
- [ ] confirm email non è lo script adeguato per i test automatici (mantenere aggiornato anche registration.php)
- [ ] Proteggere file privati da accesso web (es. keys.ini)
- [ ] dashboard / click mobile per visualizzare rettangolo bianco ("doppio click")
- [ ] cosine necessarie x accessibilità (es. alt nelle immagini, + test con browser accessibile, ...)
- [ ] Check cookie ridondante
- [ ] Scrittura politica cookie
- [ ] Check code HTTP code errors
- [ ] Generic error page
- [ ] Textarea nei form attraverso libreria JS consigliata da Ribaudo
- [ ] rivedere tutti i tag @TODO
- [ ] commentare script di login, registrazione, ...

## EXTRA:
- [ ] dashboard page per statistiche utenti => plot grafico date di nascita, nazionalità, ...
- [ ] In upload immagine di un item nello shop, ritagliarlo tramite script in dimensione uniformi</li>

## SOURCES:
- https://verifalia.com/validate-email
- <a href="https://www.f1-fansite.com/">f1-fansite</a>
- <a href="https://wallpapercave.com/">wallpapercave</a>