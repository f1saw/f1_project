# f1_project
SAW project about F1

# CLONE (w/ submodules):
- ```git clone --recursive-submodule {.git}```
<br>or<br>
```git submodule update --init --recursive```
- Update submodule ```git submodule update --remote```

<hr>

## MAURI:
- [ ] line 128 edit_profile => si può eliminare il div?

<hr>

## MATTE:
<hr>

## NOTES:
- Redirect update_profile.php ( => show_profile.php OPPURE su users/all.php)
- Upload immagini 413 (file too large)
- Sistemare parametri del log di errori (mettere err msg anche in dashboard e index)
- Verificare pulizia input, isset e prepare statement dove necesario (controllo di aver usato query semplici solo dove permesso)
- Search bar server => circuiti, drivers, teams
- Cos'è assets/image/User_detail*
- Rivedere utilizzo utility/msg_error.php (reindirizzare secondo edit.php?id=$id)
- Error Handling: order a product which has been deleted

## ALL:
- [ ] Footer
- [ ] Registration.php / error check client side => add white border to increase contrast
- [ ] Store / Products feedback based on starts (average obtained by "average" and "numbers of votes" => weighted average)
              Reviews are permitted only by authenticated users and who has bought that product
- [ ] Store / Client-side search bar (with filters such as price)
- [ ] Store / Save cart button in cart page
- [ ] Admin / can create users

- [ ] mettere err_msg e succ_msg in dashboard.php
- [ ] Proteggere file privati da accesso web 
-
- [ ] Check cookie ridondante
- [ ] Scrittura politica cookie
- [ ] Check code HTTP code errors
- [ ] Error pages
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
- https://openweathermap.org/api
- aws s3