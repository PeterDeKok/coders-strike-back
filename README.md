# coders-strike-back
My dabbling at a competitive AI for the Codingame - Coders Strike Back game

Language: `PHP`

## Competitive note
Please do not copy-paste this in the game directly, as it is a competitive programming game.
Don't ruin the fun :)

However feel free to use the code for ideas.

An exception to this is the make script, feel free to use it. 

## Install
The coders strike back game has a built in IDE where you have to paste in your code.
This IDE does not support multiple files, so if you are programming locally 
and want the benefits separating your files, you will need to do some post-processing. 

### MacOS and linux 
Run `make` to concatenate all files into `./build/main.php`

I run the following line to make the file, test the PHP syntax and copy the content to the clipboard.
`make && php72 -l ./build/main.php && cat ./build/main.php | pbcopy`

### Windows 
I did not create this yet. And I'm not planning this for the future.
However I am open to a PR.

## Future
I started of with PHP, because I never did any extensive AI in PHP before, so I want to see where that gets me.
However, I do not know if the language is efficient enough, so we will see if I stay with it, or move to something else.
The OOP structure I am using right now could also impact this, but it makes it so much more readable, so we'll see.
