<h1>Willkommen im Weimarnetz</h1>

<h2>Aktuelle Meldungen</h2>
<div class="row">
<div class="span6">
<!--
  TODO: get recent articles from wiki via JSON
  (http://www.mediawiki.org/wiki/API:Tutorial)
-->
  <ul>
    <li> 12. Jun. 12 - Vortragsreihe "Internet selbstgemacht" - Thema: <i>Follow The White Rabbit - OpenWrt verstehen</i> von Basti
</li>
    <li> 24. Apr. 12 - Vortragsreihe "Internet selbstgemacht" - Thema: <i>Clouddienste</i> von Andi
</li>
    <li> 3. Apr. 12 - Angrillen zum <a target="_blank" href="http://wireless.subsignal.org/index.php?titleTreffen" title="Treffen">Treffen</a>
</li>
  </ul>
	</div>
	<div class="span6">                                                                                                          
		<a href="http://wireless.subsignal.org/index.php?title=Vorlage:Startseite.Aktuelles&action=edit" target="_blank"><small>Text bearbeiten</small></a>
  </div>
</div>      	
<h2>Aktuelle Diskussionen</h2>
<div class="row">
<div class="span6">
<!--
  TODO: get recent articles from news via JSON
-->
  <ul>
    <li><nobr><span class="np_thread_line_text"><font color="red">05.06.</font>: <a target="_blank" href="http://news.weimarnetz.de/newsgroups/article.php?id=2852&amp;group=freifunk.de.weimar.discuss#2852">"Internet selbstgemacht"  Firmwareentwicklung Open</a> <i>von Andreas Bräu</i></span></nobr></li>
    <li><nobr><span class="np_thread_line_text"><font color="#999900">04.06.</font>: <a target="_blank" href="http://news.weimarnetz.de/newsgroups/article.php?id=2843&amp;group=freifunk.de.weimar.discuss#2843">Re: wireless-discuss Digest,  Vol 50, Issue 13</a> <i>von Stefan</i></span></nobr></li>
    <li><nobr><span class="np_thread_line_text"><font color="#999900">04.06.</font>: <a target="_blank" href="http://news.weimarnetz.de/newsgroups/article.php?id=2849&amp;group=freifunk.de.weimar.discuss#2849">Naechstes Treffen am: Dienstag, 5. Juni 2012, Ort:</a> <i>von Weimarnetz Wiki</i></span></nobr></li>
    <li><nobr><span class="np_thread_line_text">28.05.: <a target="_blank" href="http://news.weimarnetz.de/newsgroups/article.php?id=2848&amp;group=freifunk.de.weimar.discuss#2848">Naechstes Treffen am: Dienstag, 29. Mai 2012, Ort:</a> <i>von Weimarnetz Wiki</i></span></nobr></li>
    <li><nobr><span class="np_thread_line_text">27.05.: <a target="_blank" href="http://news.weimarnetz.de/newsgroups/article.php?id=2845&amp;group=freifunk.de.weimar.discuss#2845">Artikelnr. : Spende ueber  weimarnetz.de - PayPal-</a> <i>von stephan.gregory@gmx.net</i></span></nobr>
    </li>
  </ul>
	</div>
	<div class="span6">
	<A HREF="./news.php" target="_blank" >Direktlink</A> zum Newsserver<br>Benutzername: <I>freifunk</I> Passwort: <I>weimar</I>
	</div>
	</div>
	<h2>Spendenaufruf</h2>
	<div class="row">
	<div class="span6"><?php
	$wikinews=file_get_contents("http://wireless.subsignal.org/index.php?title=Vorlage:Spendenaufruf");
	$wikinews=substr($wikinews, strpos($wikinews, "<ul><li>" ), strpos($wikinews, "</li></ul>")-strpos($wikinews, "<ul><li>") + strlen("</li></ul>" ));
	echo str_replace("/index.php?title=","http://wireless.subsignal.org/index.php?title",str_replace("<a href=", "<a target=_blank href=",$wikinews) );
	?></div>
	<div class="span6">
<form action="https://www.paypal.com/cgi-bin/webscr"
method="post">
<input type="hidden" name="cmd" value="_xclick" />
<input type="hidden" name="business"
value="wireless-discuss@subsignal.org" />
<input type="hidden" name="item_name"
value="Weimarnetz e.V. Einzelspende" />
<input type="hidden" name="item_number"
value=": Spende ueber weimarnetz.de" />
<input type="hidden" name="amount" value="" />
<input type="hidden" name="lc" value="DE" />
<input type="image"
src="http://www.paypal.com/de_DE/DE/i/btn/btn_donateCC_LG.gif"
title="Paypal-Spende"
border="0" name="submit" alt="Paypal-Spende" />
<img alt="" border="0"
src="http://www.paypal.com/de_DE/i/scr/pixel.gif"
width="1" height="1" />
<input type="hidden" name="no_shipping" value="2" />
<input type="hidden" name="no_note" value="1" />
<input type="hidden" name="currency_code" value="EUR" />
<input type="hidden" name="tax" value="0" />
<input type="hidden" name="bn" value="IC_Beispiel" />
</form>
</div>
</div>