#NOTES

https://github.com/Legogo/notes

###CONCEPT

You go where the script is hosted. Then you add any filename in the url

i.e : http://www.myhost.com/notes/projectname

It will open the matching projectname.txt file stored in a files/ folder where the script is.

It will then transform whatever is in the file to a nice markdown display.

To edit you just click on the text to prompt a textarea. When you leave the textarea the file is updated.

###WHY THIS TOOL EXISTS ?

I needed a very simple tool to take notes very fast over the web (with data localy stored).
Everything is stored in txt files.

###DEPENDENCIES

I'm using strapdown for synthaxe. http://strapdownjs.com/ ( https://github.com/arturadib/strapdown )
I'm calling the strapdown.js file from the strapdownjs.com server so as long as you're online dependencies won't be a problem.


#HOW TO USE

###SYNTAX

http://daringfireball.net/projects/markdown/syntax

###OPEN A FILE/NEW FILE
Just add /[filename] to the url you're at to create a new file to edit

###EDIT A FILE
When a file is open (even this one) just click on the text to prompt the editing box. Once you're done editing just click outside of the box to valid changes.

###DELETE A FILE
Just remove everything from the editing box and submit

###VERSIONS

2014-07-02 - 0.11

* mod only left click to active layer

2014-03-28 - 0.1

* add strapdown
* add get/update scripts
* add basic navigation flow