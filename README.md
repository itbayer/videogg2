# Fork DokuWiki Plugin videogg -> videogg2

Mittels dieser Erweiterung für DokuWikis kann ein ogg /ogv Video eingebunden werden.

Original: <https://www.dokuwiki.org/plugin:videogg>

## Änderungen gegenüber dem Original

Mit der Syntax Erweiterung `intern` kann nun der Link, der bei der Media Verwaltung eingefügt wird, verwendet werden.

    {{videogg2>:zettel:test.ogv|800x|intern}}

Meldungen eingedeutscht. 

## Installation

Die Erweiterung kann über den Plugin Manager von DokuWiki installiert werden.
Link: <https://github.com/itbayer/videogg2/archive/master.zip>

### Anpassung innerhalb DokuWiki

In der Datei `..../conf/mime.conf ` muss die Zeile `ogv     audio/ogg` eingebaut werden.





