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
- [ ] NOT Working: dynamic tooltip on "cart" in order to quickly remove items from cart
<hr>

## NOTES:
- DB::connect() => empty params
- Cosa significa "Logged but in user mode, Logout" => fare redirect su dashboard?
- Cos'è assets/image/User_detail*
- Rivedere utilizzo utility/msg_error.php (reindirizzare secondo edit.php?id=$id)
- Parameters in PREPARED_STATEMENT <strong>DO NOT</strong> need to be escaped !
- Validazione con browser accessibilità e correttezza html

## ALL:
- [ ] Footer
- [ ] Registration.php / error check client side => add white border to increase contrast
- [ ] Store / Products feedback based on starts (average obtained by "average" and "numbers of votes" => weighted average)
              Reviews are permitted only by authenticated users and who has bought that product
- [ ] Store / Client-side search bar (with filters such as price)
- [ ] Store / Save cart button in cart page
- [ ] Admin / can create users
- [ ] Image uploads from local storage
- [ ] Who we are / at the left of news section in index

- [ ] mettere err_msg e succ_msg in dashboard.php
- [ ] Proteggere file privati da accesso web (es. keys.ini)
-
- [ ] cosine necessarie x accessibilità (es. alt nelle immagini, + test con browser accessibile, ...)
- [ ] Check cookie ridondante
- [ ] Scrittura politica cookie
- [ ] Check code HTTP code errors
- [ ] Error pages
- [ ] Textarea nei form attraverso libreria JS consigliata da Ribaudo
- 
- [ ] rivedere tutti i tag @TODO
- [ ] commentare script di login, registrazione, ...
- [ ] dashboard / click mobile per visualizzare rettangolo bianco ("doppio click")

## EXTRA:
- [ ] dashboard page per statistiche utenti => plot grafico date di nascita, nazionalità, ...

## SOURCES:
- https://verifalia.com/validate-email
- <a href="https://www.f1-fansite.com/">f1-fansite</a>
- <a href="https://wallpapercave.com/">wallpapercave</a>
- (teams evolution: https://i.redd.it/rp22ueq8ctea1.png)